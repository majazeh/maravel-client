@if ($username)
<span class="d-none d-sm-inline">
    <span class="direction-ltr text-left d-inline-block font-weight-bold">
        {{'@'.$username}}
    </span>
</span>
<span class="d-sm-none fs-10">
    {{$username}}
</span>

@endif
