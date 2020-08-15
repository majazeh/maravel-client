<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Models\ApiResponse;
use App\Models\ApiCollection;
use App\Models\ApiPaginator;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\UploadedFile;
use Route;

class API extends Model
{
    protected $endpointPath, $route, $can, $allows, $response, $endpoint, $routeResource;
    protected static $_cache = [];
    public $filterWith, $with = [], $fake = false, $parentModel, $filters;
    protected $guarded = [];

    public function __construct(array $attributes = [], ApiResponse $response = null)
    {
        $this->casts['id'] = 'string';
        if(!empty($attributes))
        {
            foreach (['index', 'show', 'edit', 'create', 'delete', 'update', 'store'] as $value) {
                $route = 'dashboard.' . ($this->routeResource ?: $this->getTable()) . '.' . $value;

                if(Route::has($route)){
                    $this->route[$value] = urldecode(route($route, !in_array($value, ['index', 'create', 'store']) ? [Str::singular($this->routeResource ?: $this->getTable()) => $attributes['id']] : null));
                }
            }
        }
        if(isset($attributes['can']))
        {
            $this->can = $attributes['can'];
            unset($attributes['can']);
        }
        if (isset($attributes['allows'])) {
            $this->allows = $attributes['allows'];
            unset($attributes['allows']);
        }
        if($attributes && !empty($this->with))
        {
            foreach ($attributes as $key => $value) {
                if(key_exists($key, $this->with) && key_exists($key, $attributes))
                {
                    $model = $this->with[$key];
                    if(!$value){
                        $value = null;
                    }
                    elseif(method_exists($model, 'resource'))
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
            $this->endpoint = request()->create($pure_url, 'GET', $data)->getUri();
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
            'charset: utf-8',
            'accept-Language: ' . config('app.locale')
        );

        if(User::token())
        {
            $headers[] = 'Authorization: Bearer ' . User::token();
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
                foreach ($data as $key => $value) {
                    if(is_array($value))
                    {
                        unset($data[$key]);
                        foreach ($value as $k => $v) {
                            $data[$key . "[$k]"] = $v;
                        }
                    }
                }
                $headers[] = 'Content-Type: multipart/form-data';
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            } else {
                $headers[] = 'Content-Type: application/json';
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data ? json_encode($data) : null);
            }
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response     = new ApiResponse($curl, curl_exec($curl));
        if (is_array($response->data))
        {
            $items = [];
            if (isset($response->meta->parent)) {
                $parentClass = $this->parent;
                $parent = new $parentClass((array) $response->{$response->meta->parent});
            }
            foreach ($response->data as $key => $value) {
                $item = new static((array) $value);
                if (isset($response->meta->parent)) {
                    $item->parentModel = $parent;
                }
                $items[] = $item;
            }
            if($response->links)
            {
                $paginator = new ApiPaginator($response, $items, $response->meta->total, $response->meta->per_page, $response->meta->current_page);
                $paginator->loadFilters($this);
                $path = app('request')->getSchemeAndHttpHost() . '/' . app('request')->path();
                $paginator->withPath($path);
                foreach ($paginator->response('meta')->filters->allowed as $key => $value) {
                    $paginator->appends($key, app('request')->$key);
                }
                $paginator->appends('order', app('request')->order);
                $paginator->appends('sort', app('request')->sort);
                if (isset($response->meta->parent)) {
                    $paginator->parentModel = $parent;
                }
                return $paginator;
            }
            return new ApiCollection($response, $items);
        }
        else
        {
            if (isset($response->meta->parent)) {
                $parentClass = $this->parent;
                if($parentClass)
                {
                    $parent = new $parentClass((array) $response->{$response->meta->parent});
                }
            }
            $item = new static((array) $response->data, $response);

            if (isset($parent)) {
                $item->parentModel = $parent;
            }
            return $item;
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

    public function _childIndex($parent, array $params = [])
    {
        return $this->cache(sprintf($this->endpointPath, $parent), $params);
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

    public function _childStore($parent, array $params = [])
    {
        return $this->execute(sprintf($this->endpointPath, $parent), $params, 'post');
    }


    public function _delete($id, array $params = [])
    {
        return $this->execute('%s/' .$id, $params, 'delete');
    }

    public function _allows($abilities, array $parameters = [])
    {
        try
        {
            $this->execute('gate/allows/'. $this->getTable(), [
                'abilities' => $abilities,
                'parameters' => $parameters
            ]);
            return true;
        }
        catch(\Exception $e)
        {
            return false;
        }
    }

    public function __call($method, $parameters)
    {
        if(substr($method, 0, 5) == 'flush')
        {
            return $this->flush(lcfirst(substr($method, 5)), ...$parameters);
        }
        if (substr($method, 0, 3) == 'api') {
            if(isset($this->parent) && method_exists($this, '_child' . ucfirst(substr($method, 3))))
            {
                return $this->{'_child' . ucfirst(substr($method, 3))}(...$parameters);
            }
            return $this->{'_' . substr($method, 3)}(...$parameters);
        }
        return parent::__call($method, $parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        if (substr($method, 0, 3) == 'api') {
            $clone = new static;
            return $clone->{$method}(...$parameters);
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
        if(key_exists($action, (array) $this->can))
        {
            return ((array) $this->can)[$action];
        }
        foreach ((array) $this->can as $key => $value) {
            if($value === $action)
            {
                return true;
            }
        }
        return false;
    }

    public function allows($key = null)
    {
        if(isset($this->allows->$key))
        {
            return $this->allows->$key;
        }
        return null;
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

    public function fromUTCToTimezone($time){
        return Carbon::createFromTimeString($time, 'UTC')->setTimezone(config('app.timezone'));
    }

    public function setFilters($filters)
    {
        $this->filters = $filters;
    }
    // protected function asDateTime($value)
    // {
    //     $date = parent::asDateTime($value);
    //     if(config('app.locale') == 'fa')
    //     {
    //         return \Morilog\Jalali\Jalalian::forge($value);
    //     }
    //     return $date;
    // }

    public function __get($key)
    {
        $value = parent::__get($key);
        if($value instanceof \Carbon\Carbon)
        {
            if(config('app.locale') == 'fa')
            {
                // return \Morilog\Jalali\Jalalian::forge($value);
            }
        }
        return $value;
    }
}
