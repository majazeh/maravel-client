@section('head-styles')
    <link rel="stylesheet" href="/vendors/fontawesome-pro-5.7.1/css/all.min.css">
    <link rel="stylesheet" href="/vendors/bootstrap-4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendors/bootstrap4-rtl/bootstrap4-rtl.min.css">
    @if ($layouts->vendor->select2)
        <link rel="stylesheet" href="/vendors/select2-4.0.13/dist/css/select2.min.css">
    @endif
    <link rel="stylesheet" href="/vendors/iziToast/css/iziToast.min.css">
    @if ($layouts->vendor->persian_datepicker)
        <link rel="stylesheet" href="/vendors/persian-datepicker/css/persian-datepicker.min.css">
    @endif
    <link rel="stylesheet" href="@staticVersion('/css/theme.css')">
    <link rel="stylesheet" href="@staticVersion('/css/sarkoot.css')">
@endsection
