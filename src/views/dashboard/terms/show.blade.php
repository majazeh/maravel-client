@extends($layouts->dashboard)

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $term->title }}</h5>
        @foreach ($term->parents as $parent)
            <a href="{{ route('dashboard.terms.show', ['term' => $parent->id]) }}" class="badge badge-primary">{{ $parent->title }}</a>
        @endforeach
    </div>
</div>
@endsection
