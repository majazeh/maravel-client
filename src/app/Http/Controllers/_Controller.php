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
use Illuminate\Contracts\View\Factory as ViewFactory;

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
        $global->page = str_replace('.', '-', $request->route()->getAction('as'));
        $data->ajax = $request->ajax();

        $as = $request->route()->getAction('as');
        $as_split = explode('.', $as);
        $module->as = $as;
        $module->parent = null;
        $a_resource = array_slice($as_split, 0, -1);
        if(count($a_resource) == 3)
        {
            $module->parent = Str::singular($as_split[1]);
        }
        $module->resource = join('.', $a_resource) ?: null;
        $module->action = join('.', array_slice($as_split, -1));
        $name = array_slice($as_split, -2, -1) ? array_slice($as_split, -2, -1)[0] : $module->action;

        $module->name = $module->parent ? $module->parent . '-' . $name : $name;
        $module->result = $module->action == 'index' ? $name : Str::singular($name);
        $module->singular = Str::singular($module->result);
        $global->title = __(ucfirst($module->result));
        $global->qSearch = $this->data->module->action == 'index';

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
        try {
            if(isset($this->errors) && count($this->errors)){
                $view = response(view($view, (array) $this->data)->withErrors($this->errors));
            }else{
                $view = response(view($view, (array) $this->data));
            }
        } catch (\Throwable $th) {
            if(method_exists($th, 'getPrevious') && $th->getPrevious()){
                throw $th->getPrevious();
            }
            throw $th;
        }
        if($request->ajax())
        {
            $content = $view->getContent();
            $data = json_encode($this->data->global);
            $content = "$data\n$content";
            $view->setContent($content);
        }
        return $view;
    }
}
