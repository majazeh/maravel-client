<div data-xhr="form">
    <form action="{{ route(Route::currentRouteName(), $theoryRouteParms) }}" method="POST" data-form-page="auth" class="active">
        @csrf
        @yield('auth-form')
    </form>
    @yield('auth-nav')
</div>