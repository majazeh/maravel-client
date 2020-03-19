@include('layouts.head-styles')
@include('layouts.head')
@section('main')
    <div class="enter-bg">
        <div class="enter d-flex justify-content-center align-items-center">
            <div class="enter-inner">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="text-center mb-2">
                            <a href="{{route(auth()->check() ? 'dashboard.home' : 'auth')}}" class="enter-logo direct">
                                <img src="images/logo/logo.svg" alt="Logo">
                            </a>
                        </div>

                        <h1 class="h5 text-center mb-4">
                            <a href="{{route('dashboard.home')}}" class="text-white text-decoration-none">ریسلو</a>
                        </h1>

                        <div data-xhr="form">
                            <form action="{{route(Route::currentRouteName(), $theoryRouteParms)}}" method="POST" data-form-page="auth" class="active">
                                @csrf
                                @yield('auth-form')
                            </form>
                            @yield('auth-nav')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.scripts')
@include('layouts.body')
@extends('layouts.app')
