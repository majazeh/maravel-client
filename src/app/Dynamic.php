<?php
namespace App;

class Dynamic
{
    public function __get($name)
    {
        return null;
    }

    public function arraySet(array $array)
    {
        foreach ($array as $key => $value) {
            $this->$key = $value;
        }
    }

    public function arraySetTrue(array $array){
        return $this->arraySet(array_fill_keys($array, true));
    }
}
