@if ($email)
    <a href="mailto:{{$email}}" class="direction-ltr text-left d-inline-block" target="_blank">
    <span class="d-none d-md-inline">
        {{$email}}
    </span>
    <span class="d-md-none">
        <i class="fas fa-paper-plane"></i>
    </span>
    </a>
@endif
