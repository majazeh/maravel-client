<header id="header" class="bg-white px-3 d-flex justify-content-between">
    <div class="d-flex align-items-center">
        <button id="aside-btn" class="btn btn-light d-lg-none">
            <i class="far fa-bars align-middle"></i>
        </button>
        @include('layouts.quick_search')
    </div>
    <div class="d-flex align-items-center">
        <div class="profile-div {{auth()->user()->response('current') ? 'profile-div-danger' : ''}}">
            <div class="pulse">
                <img src="{{auth()->user()->avatar_url->url('small')}}" alt="Avatar" class="profile rounded-circle" width="32" height="32">
            </div>
            <div class="profile-dropdown shadow">
                <div class="profile-dropdown-header p-3 d-flex flex-column align-items-center">
                    <a href="{{route('dashboard.users.me')}}" class="text-white text-decoration-none fs-14">{{auth()->user()->name ?: auth()->user()->id}}</a>
                    @if (auth()->user()->response('current'))
                        <a href="#" class="text-white text-decoration-none fs-14">{{auth()->user()->response('current')->name ?: auth()->user()->response('current')->id}}</a>
                    @endif
                </div>
                <div class="profile-dropdown-body p-3">
                    @if (auth()->user()->response('current'))
                        <a href="{{route('logout')}}" data-lijax='click' data-method='post' class="btn btn-primary direct">{{__('Logout')}}</a>
                        <a href="{{route('auth.back')}}" data-lijax='click' data-method='post' class="btn btn-primary direct">{{__('Admin')}}</a>
                    @else
                        <a href="{{route('logout')}}" data-lijax='click' data-method='post' class="btn btn-primary btn-block direct">{{__('Logout')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>
