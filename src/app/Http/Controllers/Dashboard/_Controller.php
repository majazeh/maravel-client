<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class _Controller extends BaseController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->data->layouts->dashboard = 'dashboard.app';
        $this->data->layouts->asideMenue = 'layouts.default-menu';
        $this->data->layouts->vendor->arraySetTrue([
            'select2',
            'persian_datepicker',
            'amcharts4',
            'fontawesome',
            'iziToast',
            'dashboardTheme',
            'popper'
        ]);
    }
}
