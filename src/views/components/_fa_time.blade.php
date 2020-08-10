@if ($_time)
    @php
        $_jalali = Morilog\Jalali\Jalalian::fromCarbon($_time);
    @endphp
    <time datetime="{{$_time}}" class="direction-ltr d-inline-block" title="{{$_jalali}}">
        @include('components.fa_time.'. $size)
    </time>
@endif
