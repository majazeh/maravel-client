@if ($time)
    <time datetime="{{$time}}" class="direction-ltr d-inline-block" title="">
        @include('components.responsiveTime.'. $size)
    </time>
@endif
