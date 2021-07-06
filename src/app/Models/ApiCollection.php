<?php
namespace App\Models;

use Illuminate\Support\Collection;

class ApiCollection extends Collection
{
    protected $filters = ['allowed' => [], 'current' => []];
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

    public function loadFilters($model){
        $meta = $this->response('meta');
        if(isset($meta->filters->allowed)){
            $this->filters['allowed'] = $meta->filters->allowed;
        }
        if(isset($meta->filters->current)){
            $current = $meta->filters->current ?: [];
            foreach($current as $key => $filter){
                if(key_exists($key, $model->filterWith)){
                    $with = $model->filterWith[$key];
                    $current->$key = is_object($filter) ? new $with((array) $filter) : $with::hydrate($filter);
                }
            }
            $this->filters['current'] = $current;
        }
    }

    public function message($text = null)
    {
        return $text ? $this->response('messageText') : $this->response('message');
    }
    public function allowedFilters(){
        return $this->filters['allowed'];
    }
    public function allowedFilter($filter){
        return isset($this->filters['allowed']->$filter) ? $this->filters['allowed']->$filter : null;
    }
    public function filters(){
        return $this->filters['current'];
    }
}
