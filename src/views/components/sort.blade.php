@isset($model->response('meta')->orders->current->$key)
    @if($model->response('meta')->orders->current->$key == 'desc')
        <a href="{{app('request')->create($model->url($model->currentPage()), 'GET', ['order' => $key, 'sort' => 'asc'])->getUri()}}"><i class="fas text-primary fa-sort-down"></i></a>
    @else
        <a href="{{app('request')->create($model->url($model->currentPage()), 'GET', ['order' => $key, 'sort' => 'desc'])->getUri()}}"><i class="fas text-primary fa-sort-up"></i></a>
    @endif
@elseif(in_array($key, $model->response('meta')->orders->allowed))
        <a href="{{app('request')->create($model->url($model->currentPage()), 'GET', ['order' => $key, 'sort' => 'desc'])->getUri()}}"><i class="fas text-black-50 fa-sort"></i></a>
@endisset
@if ($short_title)
    <span class="d-none d-md-inline">{{$title}}</span>
    <span class="d-md-none">{!!$short_title!!}</span>
@else
    {{$title}}
@endif

