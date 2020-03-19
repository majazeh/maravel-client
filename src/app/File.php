<?php
namespace App;

class File extends API
{
    protected $guarded = [];

    public static function resource($value)
    {
        if(isset($value->original))
        {
            $items = [];
            foreach ($value as $key => $v) {
                $items[$key] = new static((array) $v);
            }
            return (new static)->newCollection($items);
        }
        if (is_array($value)) {
            $value = (new static)->newCollection(array_map(function ($data){
                return new static((array) $data);
            }, $value));
        } else {
            $value = new static((array) $value);
        }
        return $value;
    }
}
