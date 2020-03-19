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

    public function report()
    {
    }
}
