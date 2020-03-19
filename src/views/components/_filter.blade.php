@php
    $allowedFilter = isset($model->response('meta')->filters->allowed->$key) ? $model->response('meta')->filters->allowed->$key : null;
@endphp
@if($allowedFilter)
    <button class="btn btn-sm btn-clear p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="{{isset($model->response('meta')->filters->current->$key) ? 'fas' : 'fal'}} fa-filter fs-12"></i>
    </button>
    @if (is_array($allowedFilter))
        <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item fs-12 {{!app('request')->$key ? 'active' : ''}}" href="{{app('request')->create($model->url($model->currentPage()), 'GET', [$key => null])->getUri()}}">{{__("All Items")}}</a>
            @foreach ($model->response('meta')->filters->allowed->$key as $item)
                <a class="dropdown-item fs-12 {{app('request')->$key == $item ? 'active' : ''}}" href="{{app('request')->create($model->url($model->currentPage()), 'GET', [$key => $item])->getUri()}}">{{__(ucfirst($item))}}</a>
            @endforeach
        </div>
    @elseif(substr($allowedFilter, 0, 1) == '$')
        <div class="dropdown-menu dropdown-menu-right keep-open">
            <select class="select2-select" name="{{$key}}" id="filter-{{$key}}" data-url="{{route('dashboard.'. Str::plural(strtolower(substr($allowedFilter, 1))) .'.index')}}" data-title='title name id' data-lijax='change' data-state='both'></select>
        </div>
    @endif
@endif
