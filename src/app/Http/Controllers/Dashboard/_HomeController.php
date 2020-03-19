<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

class _HomeController extends Controller
{
    public function index(Request $request)
    {
        return $this->view($request, 'dashboard.home.index');
    }
}
