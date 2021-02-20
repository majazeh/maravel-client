@section('auth-form')
<div class="form-group">
    <input type="password" class="form-control" id="password" name="password" placeholder="{{__('Password')}}">
</div>

<button class="btn btn-dark btn-block btn-login mb-3">{{__('Change password')}}</button>
@endsection
@section('auth-nav')
<div class="d-flex justify-content-center">
        <a href="{{route('auth')}}" class="text-light text-decoration-none font-weight-bold fs-14">{{__('Login')}}</a>
        <span class="px-2 text-white">|</span>
        <a href="{{route('register')}}" class="text-light text-decoration-none fs-14">{{__('Register')}}</a>
</div>
@endsection
@extends('auth.theory')
