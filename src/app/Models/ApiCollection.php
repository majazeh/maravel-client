<?php
namespace App\Models;

use Illuminate\Support\Collection;

class ApiCollection extends Collection
{
    public function __construct($response = null, ...$args)
    {
        if($response){
            if($response instanceof ApiResponse){
                $this->response = $response;
            }
            else{
                array_unshift($args, $response);
            }
        }
        parent::__construct(...$args);
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
}
