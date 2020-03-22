@extends($layouts->dashboard)

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Terms') }} <sup>({{ $terms->total() }})</sup>
            @filterBadge($terms)
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>@sortView($terms, 'id', '#')</th>
                            <th>@sortView($terms, 'title')</th>
                            <th>
                                @sortView($terms, 'parent')
                                @filterView($terms, 'parent')
                            </th>
                            <th>
                                @sortView($terms, 'creator')
                                @filterView($terms, 'creator')
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($terms as $term)
                            <tr>
                                <td>
                                    @id($term)
                                </td>
                                <td>
                                    {{ $term->title }}
                                </td>
                                <td>
                                    @foreach ($term->parents as $parent)
                                        <a href="{{ route('dashboard.terms.show', ['term' => $parent]) }}"  class="badge badge-secondary">{{ $parent->title }}</a>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{route('dashboard.users.show', $term->creator->id)}}">{{ $term->creator->name ?: $term->creator->id }}</a>
                                </td>
                                <td>
                                    @if ($term->can('edit'))
                                        <a href="{{route('dashboard.terms.edit', ['term' => $term->id])}}" title="{{__('Edit')}}">
                                            <i class="fas fa-edit text-primary fs-14"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{$terms->render()}}
            </div>
        </div>
    </div>
@endsection
