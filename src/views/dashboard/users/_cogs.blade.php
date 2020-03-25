<button class="btn btn-sm btn-clear p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="far fa-cogs fs-12 text-primary"></i>
</button>
@if ($user->can('edit'))
    <div class="dropdown-menu">
        <a href="{{route('dashboard.users.edit', ['user' => $user->id])}}" title="{{__('Edit')}}" class="dropdown-item fs-12">
            <i class="far fa-user-cog text-primary"></i> {{__('Edit')}}
        </a>
        @if (app('request')->user()->type == 'admin')
            <a href="{{route('auth.as', ['user' => $user->id])}}" class="dropdown-item fs-12" data-lijax="click" data-method="POST">
                <i class="fal fa-user-secret text-primary"></i> {{__('Login to this...')}}
            </a>
        @endif
        @includeIf('dashboard.users.cogItems')
    </div>
@endif
