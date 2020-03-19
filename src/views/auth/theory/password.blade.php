@section('auth-form')
<div class="form-group">
    <input type="password" class="form-control" id="password" name="password" placeholder="{{__('Passowrd')}}">
</div>

<button class="btn btn-dark btn-block btn-login mb-3">{{__('Check')}}</button>
@endsection
@extends('auth.theory')
