<?php
namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Term;

class _TermController extends Controller
{
    public function index(Request $request)
    {
        $this->data->terms = Term::apiIndex($request->all(['order', 'sort', 'parent', 'creator', 'page']));
        return $this->view($request, 'dashboard.terms.index');
    }

    public function create(Request $request)
    {
        return $this->view($request, 'dashboard.terms.create');
    }

    public function store(Request $request)
    {
        return Term::apiStore($request->except('_method'))->response()->json([
            'redirect' => route('dashboard.terms.create')
        ]);
    }

    public function edit(Request $request, Term $term)
    {
        return $this->view($request, 'dashboard.terms.create', ['term' => $term]);
    }

    public function update(Request $request, $term)
    {
        return Term::apiUpdate($term, $request->except('_method'))->response()->json(['redirect' => route('dashboard.terms.edit', ['term'=>$term])]);
    }

    public function show(Request $request, Term $term)
    {
        return $this->view($request, 'dashboard.terms.show', ['term' => $term]);
    }
}
