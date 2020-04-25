@section('scripts')
    <script src="/vendors/jquery-3.4.1.min.js"></script>
    @if ($layouts->vendor->popper)
        <script src="/vendors/popper.min.js"></script>
    @endif
    <script src="/vendors/bootstrap-4.4.1/js/bootstrap.min.js"></script>
    @if ($layouts->vendor->select2)
        <script src="/vendors/select2-4.0.13/dist/js/select2.min.js"></script>
    @endif
    @if ($layouts->vendor->iziToast)
        <script src="/vendors/iziToast/js/iziToast.min.js"></script>
    @endif
    @if ($layouts->vendor->persian_datepicker)
        <script src="/vendors/persian-date/persian-date.min.js"></script>
        <script src="/vendors/persian-datepicker/js/persian-datepicker.min.js"></script>
    @endif

    @if ($layouts->vendor->amcharts4)
        <script src="/vendors/amcharts4/core.js"></script>
        <script src="/vendors/amcharts4/charts.js"></script>
        <script src="/vendors/amcharts4/themes/amcharts.js"></script>
        <script src="/vendors/amcharts4/lang/en.js"></script>
    @endif

    <script src="@staticVersion('/js/sarkoot.min.js')"></script>

    <script src="@staticVersion('js/app.js')"></script>
@endsection
