@extends($layouts->dashboard)

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-8 col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-header">
                    {{__(($module->action == 'create' ? "Create " : 'Edit ') . Str::singular($module->name))}}
                </div>
                @yield('before_content')
                <form class="" action="@yield('form_action', route($module->resource . ($module->action == 'edit' ? '.update' : '.store'), $module->action == 'edit' ? [$module->result => $result->id] : null))" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="{{$module->action == 'edit' ? 'PUT' : 'POST'}}">
                    <div class="card-body">
                        @yield('form_content')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn {{$module->action == 'edit' ? 'btn-primary' : 'btn-success' }}">
                            {{__(($module->action == 'create' ? 'Create ' : 'Update ' ) . Str::singular($module->name))}}
                        </button>
                        @if(Route::has($module->resource . '.index'))
                            <a href="{{route($module->resource . '.index')}}" class="btn btn-light">{{ __('Cancel') }}</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
