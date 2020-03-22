<div id="subheader" class="subheader py-3" data-xhr="subheader">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-baseline">
            <div class="d-flex align-items-baseline">
                <h3 class="subheader-title">{{__('Dashboard')}}</h3>
                @if (Breadcrumbs::exists(\Route::getCurrentRoute()->getAction('as')))
                    {{ Breadcrumbs::render(\Route::getCurrentRoute()->getAction('as'), get_defined_vars()) }}
                @endif
                @if((!Gate::has("$module->resource.create") || Gate::allows("$module->resource.create")) && Route::has("$module->resource.create") && \Route::getCurrentRoute()->getAction('as') != "$module->resource.create")
                    <a href="{{route("$module->resource.create")}}" class="badge badge-success mx-2">{{__("Create new " . Str::singular($module->name))}}</a>
                @endif
            </div>
            <div></div>
        </div>
    </div>
</div>
