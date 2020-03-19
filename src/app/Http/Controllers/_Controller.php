<?php

namespace App\Http\Controllers;

use App\Dynamic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use stdClass;
use Str;

class _Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(Request $request)
    {
        $this->data = $data = new stdClass;
        $this->data->global = $global = new stdClass;
        $this->data->layouts = $layouts = new stdClass;
        $this->data->layouts->vendor = new Dynamic;
        $this->data->module = $module = new stdClass;
        $global->description = 'Description';
        $global->title = 'Title';
        $data->ajax = $request->ajax();

        $as = $request->route()->getAction('as');
        $as_split = explode('.', $as);
        $module->as = $as;
        $module->resource = join('.', array_slice($as_split, 0, 2));
        $module->action = join('.', array_slice($as_split, -1));
        $name = array_slice($as_split, -2, -1) ? array_slice($as_split, -2, -1)[0] : $module->action;

        $module->name = $name;
        $module->result = $module->action == 'index' ? $name : Str::singular($name);
    }

    public function view(Request $request, $view, $data = [])
    {
        foreach ($data as $key => $value) {
            $this->data->$key = $value;
        }
        if(isset($this->data->{$this->data->module->result}))
        {
            $this->data->result = $this->data->{$this->data->module->result};
        }
        if(strpos(strtolower($request->headers->get('accept')), 'application/json') !== false && isset($this->data->result))
        {
            return $this->data->result;
        }
        return view($view, (array) $this->data);
    }
}
