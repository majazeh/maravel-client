@section('auth-nav')
<div class="d-flex justify-content-center">
    @if (!auth()->check())
        <a href="{{route('auth')}}" class="text-light text-decoration-none font-weight-bold fs-14">{{__('Login')}}</a>
        @if (config('auth.registration', true))
            <span class="px-2 text-white">|</span>
            <a href="{{route('register')}}" class="text-light text-decoration-none font-weight-bold fs-14">{{__('Register')}}</a>
        @endif
        <span class="px-2 text-white">|</span>
        <a href="{{route('auth.recovery')}}" class="text-light text-decoration-none fs-14">{{__('Forgot Password')}}</a>
    @else
        <a href="{{route('dashboard.home')}}" class="text-light text-decoration-none fs-14 font-weight-bold direct">{{__('Dashboard')}}</a>
            <span class="px-2 text-white">|</span>
        <a href="{{route('logout')}}" data-lijax="click" data-method="POST" class="text-light text-decoration-none fs-14">{{__('Logout')}}</a>
    @endif
</div>
@endsection
@extends($ajax ? 'auth.xhr' : 'auth.app')
