<?php
namespace App\Http\Controllers\Dashboard;

use App\Requests\Maravel as Request;

use App\Term;
use Illuminate\Support\Facades\Gate;

class _TermController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::has('dashboard.terms.viewAny'))
        {
            $this->authorize('dashboard.terms.viewAny');
        }
        $this->data->terms = Term::apiIndex($request->all(['order', 'sort', 'parent', 'creator', 'page']));
        return $this->view($request, 'dashboard.terms.index');
    }

    public function create(Request $request)
    {
        if (Gate::has('dashboard.terms.create')) {
            $this->authorize('dashboard.terms.create');
        }
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
        if (Gate::has('dashboard.terms.update')) {
            $this->authorize('dashboard.terms.update', [$term]);
        }
        return $this->view($request, 'dashboard.terms.create', ['term' => $term]);
    }

    public function update(Request $request, $term)
    {
        return Term::apiUpdate($term, $request->except('_method'))->response()->json(['redirect' => route('dashboard.terms.edit', ['term'=>$term])]);
    }

    public function show(Request $request, Term $term)
    {
        if (Gate::has('dashboard.terms.view')) {
            $this->authorize('dashboard.terms.view', [$term]);
        }
        return $this->view($request, 'dashboard.terms.show', ['term' => $term]);
    }
}
