<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Models\ApiResponse;
use App\Models\ApiCollection;
use App\Models\ApiPaginator;
use Closure;
use Illuminate\Http\UploadedFile;
use Route;

class API extends Model
{
    protected $endpointPath, $route, $can, $response, $endpoint, $fake = false;
    protected static $_cache = [];
    public $filterWith, $with = [];
    protected $guarded = [];

    public function __construct(array $attributes = [], ApiResponse $response = null)
    {
        if(!empty($attributes))
        {
            foreach (['index', 'show', 'edit', 'create', 'delete', 'update', 'store'] as $value) {
                $route = 'dashboard.' . $this->getTable() . '.' . $value;
                if(Route::has($route)){
                    $this->route[$value] = route($route, !in_array($value, ['index', 'create', 'store']) ? [Str::singular($this->getTable()) => $attributes['id']] : null);
                }
            }
        }
        if(isset($attributes['can']))
        {
            $this->can = $attributes['can'];
            unset($attributes['can']);
        }
        if($attributes && !empty($this->with))
        {
            foreach ($attributes as $key => $value) {
                if(key_exists($key, $this->with) && key_exists($key, $attributes))
                {
                    $model = $this->with[$key];
                    if(method_exists($model, 'resource'))
                    {
                        $value = $model::resource($value);
                    }
                    else
                    {
                        if(is_array($value))
                        {
                            $value = $this->newCollection(array_map(function($data) use ($model){
                                return new $model((array) $data);
                            }, $value));
                        }
                        else
                        {
                            $value = new $model((array) $value);
                        }
                    }
                    $this->setRelation($key, $value);
                    unset($attributes[$key]);
                }
            }
        }
        parent::__construct($attributes);
        $this->casts['id'] = 'string';
        $this->response = $response;
    }

    public function response($key = null)
    {
        return $key ? $this->response->$key : $this->response;
    }

    public function isOK()
    {
        return $this->response('is_ok');
    }

    public function message($text = null)
    {
        return $text ? $this->response('messageText') : $this->response('message');
    }

    public static function path()
    {
        return trim(env('SERVER_URL'), '/') . '/';
    }

    public function endpoint($endpoint = null, array $data = [], $method = 'GET')
    {
        $method = strtoupper($method);
        if($this->endpoint && !$endpoint)
        {
            return $this->endpoint;
        }
        $path = isset($this->endpointPath) ? $this->endpointPath : $this->getTable();
        $endpoint = $endpoint ? (substr($endpoint, 0, 2) == '%s' ? $path . substr($endpoint, 2) : $endpoint) : $path;
        $method = strtoupper($method);
        $this->endpoint = $pure_url = static::path() . trim($endpoint, '\/');
        if ($method == 'GET' && !empty($data)) {
            $parse_url = parse_url($pure_url);

            $parse_url['query'] = isset($parse_url['query']) ? $parse_url['query'] . '&' . http_build_query($data) : http_build_query($data);
            $this->endpoint = $parse_url['scheme']
                . '://'
                . $parse_url['host']
                . (isset($parse_url['port']) ? ':' . $parse_url['port'] : '')
                . (isset($parse_url['path']) ? $parse_url['path'] : '/')
                . (isset($parse_url['query']) ? '?' . $parse_url['query'] : '');
        }
        return $this->endpoint;
    }

    public function execute($endpoint = null, array $data = [], $method = 'GET', Closure $callback = null)
    {
        $method = strtoupper($method);
        $endpoint = $this->endpoint(...func_get_args());
        if($this->fake)
        {
            return $endpoint;
        }
        $headers       = array(
            'Accept: application/json',
            'charset: utf-8'
        );
        if(User::$token)
        {

            $headers[] = 'Authorization: Bearer ' . User::$token;
        }
        $curl = curl_init($endpoint);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if($method != 'GET')
        {
            $hasFile = false;
            if (in_array($method, ['PUT', 'PATCH', 'POST']))
            {
                foreach ($data as $key => $value) {
                    if($value instanceof UploadedFile)
                    {
                        $hasFile = true;
                        $data[$key] = new \CURLFile($value->getPathname(), $value->getMimeType(), $value->getClientOriginalName());;
                        $method = 'POST';
                    }
                }
            }
            if ($hasFile) {
                $headers[] = 'Content-Type: multipart/form-data';
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            } else {
                $headers[] = 'Content-Type: application/json';
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data ? json_encode($data) : null);
            }
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response     = new ApiResponse($curl, curl_exec($curl), [
            'filterWith' => $this->filterWith
        ]);
        if (is_array($response->data))
        {
            $items = [];
            foreach ($response->data as $key => $value) {
                $items[] = new static((array) $value);
            }
            if($response->links)
            {
                $paginator = new ApiPaginator($response, $items, $response->meta->total, $response->meta->per_page, $response->meta->current_page);
                $path = app('request')->getSchemeAndHttpHost() . '/' . app('request')->path();
                $paginator->withPath($path);
                foreach ($paginator->response('meta')->filters->allowed as $key => $value) {
                    $paginator->appends($key, app('request')->$key);
                }
                $paginator->appends('order', app('request')->order);
                $paginator->appends('sort', app('request')->sort);
                return $paginator;
            }
            return new ApiCollection($response, $items);
        }
        else
        {
            return new static((array) $response->data, $response);
        }

        return $response;
    }

    public function cache(...$parameters)
    {
        $url = md5($this->endpoint(...$parameters));
        if($this->fake)
        {
            return $this->execute(...$parameters);
        }
        if(isset(static::$_cache[$url]))
        {
            return static::$_cache[$url];
        }
        static::$_cache[$url] = $this->execute(...$parameters);
        return static::$_cache[$url];
    }

    public function flush($opr, ...$parameters)
    {
        $url = md5($this->endpoint(...$parameters));
        if (isset(static::$_cache[$url])) {
            unset(static::$_cache[$url]);
        }
        return $this->cache(...$parameters);
    }

    public function _index(array $params = [])
    {
        return $this->cache(null, $params);
    }

    public function _show($id, array $params = [])
    {
        return $this->cache('%s/' .$id, $params);
    }

    public function _update($id, array $params = [])
    {
        return $this->cache('%s/' .$id, $params, 'put');
    }

    public function _store(array $params = [])
    {
        return $this->execute(null, $params, 'post');
    }

    public function _delete($id, array $params = [])
    {
        return $this->execute('%s/' .$id, $params, 'delete');
    }

    public function __call($method, $parameters)
    {
        if(substr($method, 0, 5) == 'flush')
        {
            return $this->flush(lcfirst(substr($method, 5)), ...$parameters);
        }
        return parent::__call($method, $parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        if (substr($method, 0, 3) == 'api') {
            $clone = new static;
            return $clone->{'_'.substr($method, 3)}(...$parameters);
        }
        return parent::__callStatic($method, $parameters);
    }

    public function getSerialAttribute()
    {
        return [substr($this->id, 0, 2), substr($this->id, 2)];
    }

    public function route($route)
    {
        if(isset($this->route[$route]))
        {
            return $this->route[$route];
        }
        return null;
    }

    public function can($action)
    {
        return in_array($action, $this->can ?: []);
    }
    public function check($action)
    {
        if(!$this->can($action)){
            throw new AccessDeniedHttpException(__('THIS ACTION IS UNAUTHORIZED'));
        }
        return $this;
    }
    public function __toString()
    {
        if(!isset($this->isFilter))
        {
            return parent::__toString();
        }
        return $this->title ?: $this->name ?: $this->id ;
    }
    public function resolveRouteBinding($value, $filed = null)
    {
        return $this->_show($value);
    }
}
