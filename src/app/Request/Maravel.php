<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class Maravel extends FormRequest
{
    public function authorize()
    {
        $action = $this->route()->getAction('as');
        $aAaction = explode('.', $action);
        $method = last($aAaction);
        array_pop($aAaction);
        switch ($method) {
            case 'index':
                $method = 'viewAny';
                break;
            case 'show':
                $method = 'view';
                break;
            case 'create':
            case 'store':
                $method = 'create';
                break;
            case 'edit':
            case 'update':
                $method = 'update';
                break;
            case 'destroy':
                $method = 'delete';
                break;
        }
        $aAaction[] = $method;
        $action = join('.', $aAaction);
        $auth = true;
        if (in_array($action, array_keys(Gate::abilities()))) {
            return Gate::allows($action, array_values($this->route()->parameters()));
        }
        return $auth;
    }

    public function rules()
    {
        return [];
    }
}
