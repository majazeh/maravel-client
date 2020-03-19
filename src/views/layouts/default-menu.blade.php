@section('default-menu')
    <li class="nav-item">
        <a class="nav-link text-truncate" href="{{route('dashboard.users.index')}}">
            <span class="d-sm-inline">{{__('Users')}}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-truncate" href="{{route('dashboard.terms.index')}}">
            <span class="d-sm-inline">{{__('Terms')}}</span>
        </a>
    </li>
@show
