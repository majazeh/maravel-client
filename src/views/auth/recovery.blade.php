@section('auth-form')
<div class="form-group">
    <input type="text" class="form-control" id="username" name="username" placeholder="{{__('Mobile')}}">
</div>

<button class="btn btn-dark btn-block btn-login mb-3">{{__('Receive code')}}</button>
@endsection

@section('auth-nav')
<div class="d-flex justify-content-center">
        <a href="{{route('auth')}}" class="text-light text-decoration-none font-weight-bold fs-14">{{__('Login')}}</a>
        <span class="px-2 text-white">|</span>
        <a href="{{route('register')}}" class="text-light text-decoration-none fs-14">{{__('Register')}}</a>
</div>
@endsection
@extends('auth.theory')
