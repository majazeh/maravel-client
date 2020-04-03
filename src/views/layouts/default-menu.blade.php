@section('default-menu')
    @can('dashboard.users.viewAny')
        <li class="nav-item">
            <a class="nav-link text-truncate" href="{{route('dashboard.users.index')}}">
                <span class="d-sm-inline">{{__('Users')}}</span>
            </a>
        </li>
    @endcan
    @can('dashboard.terms.viewAny')
        <li class="nav-item">
            <a class="nav-link text-truncate" href="{{route('dashboard.terms.index')}}">
                <span class="d-sm-inline">{{__('Terms')}}</span>
            </a>
        </li>
    @endcan
@show
