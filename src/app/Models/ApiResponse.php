<?php
namespace App\Models;
use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\HttpFoundation\Cookie;

use App\Exceptions\APIException;

use App\User;
use App\API;

class ApiResponse implements Arrayable
{
    protected $curl, $response, $code, $content_type;
    public function __construct($curl, $response, array $options = [])
    {
        if($curl !== 0)
        {
            if (false === is_resource($curl) && \get_resource_type($curl) != 'curl') {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Argument must be a valid curl resource type. %s given.',
                        gettype($curl)
                    )
                );
            }
            $this->curl = $curl;
            $this->code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $this->content_type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
            $curl_errno   = curl_errno($curl);
            $curl_error   = curl_error($curl);
            if ($curl_errno) {
                throw new \Exception($curl_error);
            }
        }

        $this->response = is_array($response) || is_object($response) ? (object) $response : json_decode($response);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo($response);
            exit();
            throw new \JsonException('Could not parse data');
        }
        if (!$this->response) {
            throw new \JsonException('Response is null');
        }

        if (isset($this->response->url)) {
            $this->response->url = str_replace(API::path(), app('request')->getSchemeAndHttpHost() . '/', $this->response->url);
        }
        if($this->response->message == 'UNAUTHENTICATED')
        {
            session()->put('APIToken', null);
            return redirect()->route('auth')->send();
        }
        if (!$this->response->is_ok)
        {
            throw new APIException($this);
        }
    }

    public function statusCode()
    {
        return $this->code;
    }

    public function json(array $params = [])
    {
        return response()->json(array_merge_recursive((array) $this->response, $params), $this->code);
    }

    public function toArray()
    {
        return (array) $this->response;
    }

    public function __get($name)
    {
        return isset($this->response->$name) ? $this->response->$name : null;
    }
}
