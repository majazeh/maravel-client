<?php
namespace App\Models;

use Illuminate\Pagination\LengthAwarePaginator;

class ApiPaginator extends LengthAwarePaginator
{
    public $response, $filters = [];
    public function __construct(ApiResponse $response, ...$args)
    {
        parent::__construct(...$args);
        $this->response = $response;

    }
    public function loadFilters($model)
    {
        if ($this->response('meta') && isset($this->response('meta')->filters->current)) {
            foreach ($this->response('meta')->filters->current as $key => $value) {
                $this->filters[$key] = isset($model->filterWith[$key]) ? new $model->filterWith[$key]((array) $value) : $value;
            }
            foreach ($this as $key => $value) {
                $value->setFilters($this->filters);
            }
        }
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
    public function getFilter($name)
    {
        return isset($this->filters[$name]) ? $this->filters[$name] : null;
    }
}
