@extends($layouts->dashboard)

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-6">
            <div class="card">
                <div class="card-header">
                    @yield('form-title', __(($module->action == 'create' ? "Create " : 'Edit ') . $module->singular))
                    @yield('content-header')
                </div>
                @yield('before_content')
                @section('form-tag')
                    <form class="" action="@yield('form_action', request()->create(isset(${$module->result}) ? ${$module->result}->route('update') : route("$module->resource.store", ($module->parent ? request()->route()->parameters[$module->parent] : null)), 'GET', request()->all())->getUri())" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="{{$module->action == 'edit' ? 'PUT' : 'POST'}}">
                        <div class="card-body">
                            @yield('form_content')
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn {{$module->action == 'edit' ? 'btn-primary' : 'btn-success' }}">
                                {{__(($module->action == 'create' ? 'Create ' : 'Update ' ) . $module->singular)}}
                            </button>
                            @if(Route::has($module->resource . '.index'))
                                <a href="{{route($module->resource . '.index', $module->parent ? request()->route()->parameters[$module->parent] : null)}}" class="btn btn-light">{{ __('Cancel') }}</a>
                            @endif
                        </div>
                    </form>
                @show
            </div>
            @yield('other-card')
        </div>
        @yield('other-content')
    </div>
@endsection
