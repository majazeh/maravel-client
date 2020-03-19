@section('aside')
    <aside id="aside">
        <div class="aside-brand d-flex justify-content-center align-items-center px-3">
            <h1 class="mb-0">
                <a href="/" class="text-white text-decoration-none" target="_blank">{{__('App Title')}}</a>
            </h1>
        </div>
        <ul class="nav aside-nav flex-column flex-nowrap overflow-hidden p-0">
            <li class="nav-item">
                <a class="nav-link text-truncate" href="{{route('dashboard.home')}}">
                    <span class="d-sm-inline">{{__('Dashboard')}}</span>
                </a>
            </li>
            @include($layouts->asideMenue)
        </ul>
    </aside>
@endsection
