@section('auth-form')
<div class="form-group">
    <input type="text" class="form-control text-left direction-ltr placeholder-right" id="authorized_key" name="authorized_key" value="{{app('request')->authorized_key}}" placeholder="{{auth()->check() ? __('Entry Command') : __('Phone, Email or Username')}}">
</div>

<button class="btn btn-dark btn-block btn-login mb-3">{{auth()->check() ? __('Check') : __('Enter')}}</button>
@endsection

@section('auth-nav')
<div class="d-flex justify-content-center">
    @if (auth()->check())
        <a href="{{route('dashboard.home')}}" class="text-light text-decoration-none fs-14 font-weight-bold direct">{{__('Dashboard')}}</a>
            <span class="px-2 text-white">|</span>
        <a href="{{route('logout')}}" data-lijax="click" data-method="POST" class="text-light text-decoration-none fs-14">{{__('Logout')}}</a>
    @else
        <a href="{{route('auth.recovery')}}" class="text-light text-decoration-none fs-14">{{__('Forgot Password')}}</a>
        @if (config('auth.registration', true))
            <span class="px-2 text-white">|</span>
            <a href="{{route('auth.verification')}}" class="text-light text-decoration-none font-weight-bold fs-14">{{__('Mobile verify')}}</a>
            <span class="px-2 text-white">|</span>
            <a href="{{route('register')}}" class="text-light text-decoration-none font-weight-bold fs-14">{{__('Register')}}</a>
        @endif
    @endif
</div>
@endsection
@extends($ajax ? 'auth.xhr' : 'auth.app')
