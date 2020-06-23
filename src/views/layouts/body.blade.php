@section('body')
    <body class="d-flex flex-column rtl" data-page="{{isset($global->page) ? $global->page : ''}}">
        @yield('aside')
        @yield('main')
        @yield('scripts')
    </body>
@endsection
