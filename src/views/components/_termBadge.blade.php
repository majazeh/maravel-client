<span class="badge badge-secondary">
    @if ($term->cat)
        <span class="d-none d-md-inline">
            {{$term->cat}}:
        </span>
    @endif
    {{$term->title}}
</span>
