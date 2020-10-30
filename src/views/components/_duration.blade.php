<span class="d-none d-md-inline">
    {{ __(":time $type(s)", ['time' => $duration]) }}
</span>
<span class="d-md-none">
    {{ __(":time short_$type(s)", ['time' => $duration]) }}
</span>