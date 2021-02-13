@section('auth-form')
    @if (request()->callback)
        <div class="mb-1">
            {{ __("To continue the process you need to login or register") }}
        </div>
    @endif
    <div class="mb-4">
        <input type="text" class="w-full text-sm text-left dir-ltr placeholder-right border border-gray-200 rounded-sm" id="authorized_key" name="authorized_key" value="{{ app('request')->authorized_key }}" placeholder="{{ auth()->check() ? __('Entry Command') : __('Phone, Email or Username') }}">
    </div>
    <button class="w-full h-10 text-sm rounded-full bg-blue-600 text-white hover:bg-blue-700 transition mb-4">{{ auth()->check() ? __('Check') : __('Enter') }}</button>
@endsection

@section('auth-nav')
    <div class="flex justify-center">
        @if (auth()->check())
            <a href="{{ route('dashboard.home') }}" class="font-bold direct">{{ __('Dashboard') }}</a>
            <span class="px-4 text-gray-500">|</span>
            <a href="{{ route('logout') }}" data-lijax="click" data-method="POST">{{__('Logout')}}</a>
        @else
            @if (config('auth.registration', true))
                <a href="{{ route('register', ['callback' => request()->callback]) }}" class="text-sm font-bold text-gray-700 hover:text-gray-900 transition">{{ __('Register') }}</a>
            @endif
            <span class="px-4 text-gray-500">|</span>
            <a href="{{ route('auth.recovery') }}" class="text-sm text-gray-700 hover:text-gray-900 transition">{{ __('Forgot Password') }}</a>
        @endif
    </div>
@endsection

@extends($ajax ? 'auth.xhr' : 'auth.app')