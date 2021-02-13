@section('auth-form')
    <div class="mb-4">
        <input type="text" class="w-full text-sm text-left dir-ltr placeholder-right border border-gray-200 rounded-sm" id="username" name="username" placeholder="{{ __('Mobile') }}">
    </div>
    <button class="text-sm w-full rounded-full h-10 bg-blue-600 text-white hover:bg-blue-700 transition mb-4">{{ __('Receive code') }}</button>
@endsection

@section('auth-nav')
    <div class="flex justify-center">
        <a href="{{ route('auth') }}" class="text-sm text-gray-700 hover:text-gray-900 transition">{{ __('Login') }}</a>
        <span class="px-4 text-gray-500">|</span>
        <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-gray-900 transition">{{ __('Register') }}</a>
    </div>
@endsection

@extends('auth.theory')