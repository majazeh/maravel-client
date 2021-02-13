@include('layouts.head-styles')
@include('layouts.head')

@section('main')
    <div class="flex-1 flex justify-center items-center">
        <div class="border border-gray-200 p-8 rounded sm:w-96">
            <div class="mb-2">
                <a href="{{ route(auth()->check() ? 'dashboard.home' : 'auth') }}" class="block mx-auto w-12 h-12 direct">
                    @if (auth()->check() && auth()->user()->avatar_url->url('large'))
                        <img src="{{auth()->user()->avatar_url->url('large')}}" alt="Avatar">
                    @else
                        <img src="/images/logo/logo.png" alt="{{ __('App Title') }}" width="64" height="64">
                    @endif
                </a>
            </div>

            <h1 class="text-lg text-center font-bold text-gray-900 mb-4">
                <a href="{{ route(auth()->check() ? 'dashboard.home' : 'auth') }}">
                    @if (auth()->check())
                        {{ auth()->user()->name ?: __('Anonymouse') }}
                    @else
                        {{__('App Title')}}
                    @endif
                </a>
            </h1>

            <div data-xhr="form">
                <form action="{{ route(Route::currentRouteName(), $theoryRouteParms) }}" method="POST" data-form-page="auth" class="active">
                    @csrf
                    @yield('auth-form')
                </form>
                @yield('auth-nav')
            </div>
        </div>
    </div>
@endsection

@include('layouts.scripts')
@include('layouts.body')
@extends('layouts.app')