@section('auth-form')
    <div class="mb-4">
        <input type="password" class="w-full text-sm text-left dir-ltr placeholder-right border border-gray-200 rounded-sm" id="password" name="password" placeholder="{{ __('Password') }}">
    </div>

    <button class="w-full h-10 text-sm rounded-full bg-blue-600 text-white hover:bg-blue-700 transition mb-4">{{ __('Change password' )}}</button>
@endsection

@section('auth-nav')
    <div class="flex justify-center">
        <a href="{{ route('auth') }}" class="text-sm">{{ __('Login') }}</a>
        <span class="px-4 text-gray-500">|</span>
        <a href="{{ route('register') }}" class="text-sm">{{ __('Register') }}</a>
    </div>
@endsection

@extends('auth.theory')