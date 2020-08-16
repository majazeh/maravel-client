@section('auth-form')
@if (request()->callback)
    <div class="fs-14 mb-1 text-secondary">
        {{__("To continue the process you need to login or register")}}
    </div>
@endif
<div class="form-group">
    <input type="text" class="form-control" id="name" name="name" placeholder="{{__('DisplayName')}}">
</div>

<div class="form-group">
    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="{{__('Mobile')}}">
</div>

<div class="form-group">
    <input type="password" class="form-control" id="password" name="password" placeholder="{{__('Password')}}">
</div>
<button class="btn btn-dark btn-block btn-login mb-3">{{__('Register')}}</button>
@endsection
@section('auth-nav')
<div class="d-flex justify-content-center">
    @if (auth()->check())
        <a href="{{route('dashboard.home')}}" class="text-light text-decoration-none fs-14 font-weight-bold direct">{{__('Dashboard')}}</a>
            <span class="px-2 text-white">|</span>
        <a href="{{route('logout')}}" data-lijax="click" data-method="POST" class="text-light text-decoration-none fs-14">{{__('Logout')}}</a>
    @else
        <a href="{{route('auth', ['callback' => request()->callback])}}" class="text-light text-decoration-none font-weight-bold fs-14">{{__('Login')}}</a>
        <span class="px-2 text-white">|</span>
        <a href="{{route('auth.recovery')}}" class="text-light text-decoration-none fs-14">{{__('Forgot Password')}}</a>
    @endif
</div>
@endsection
@extends('auth.theory')
