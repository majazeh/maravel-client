<?php
namespace App\Exceptions;
// use App\Exceptions\Handler

class APIException extends \RuntimeException
{
    protected $response;
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function __call($name, $arguments)
    {
        return $this->response->$name(...$arguments);
    }

    public function __get($name)
    {
        return $this->response->$name;
    }

    public function response()
    {
        return $this->response;
    }

    public function report()
    {
    }

    public function render($request)
    {
        if($request->ajax())
        {
            return $this->response->json();
        }
        else
        {
            if(config('app.debug'))
            {
                return $this->response->json();
            }
            abort($this->response->statusCode(), $this->message_text);
        }
    }
}
