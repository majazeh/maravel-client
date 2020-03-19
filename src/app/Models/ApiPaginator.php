<?php
namespace App\Models;

use Illuminate\Pagination\LengthAwarePaginator;

class ApiPaginator extends LengthAwarePaginator
{
    public $response;
    public function __construct(ApiResponse $response, ...$args)
    {
        parent::__construct(...$args);
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
}
