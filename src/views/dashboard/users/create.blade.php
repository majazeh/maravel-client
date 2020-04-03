@isset($user)
    @if (auth()->isAdmin() && !request()->has('userview'))
        @if (\View::exists('dashboard.users.forms.'.$user->type))
            @section('content-header')
                <a href="{{request()->create(url()->current(), 'GET', ['userview' => true])->getUri()}}" class="badge badge-secondary fs-10">
                    {{__('User view')}}
                </a>
            @endsection
        @endif
        @includeFirst(['dashboard.users.forms.default', 'dashboard.users.forms._default'])
    @else
        @if (\View::exists('dashboard.users.forms.'.$user->type) && auth()->isAdmin())
            @section('content-header')
                <a href="{{request()->create(url()->current(), 'GET', ['userview' => null])->getUri()}}" class="badge badge-secondary fs-10">
                    {{__('Default view')}}
                </a>
            @endsection
        @endif
        @includeFirst(['dashboard.users.forms.'.$user->type, 'dashboard.users.forms.default', 'dashboard.users.forms._default'])
    @endif
@else
    @includeFirst(['dashboard.users.forms.default', 'dashboard.users.forms._default'])
@endif
