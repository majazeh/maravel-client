@foreach($model->response('meta')->filters->current as $key => $value)
    @if (is_array($value))
        @foreach ($value as $k => $item)
            @php
                $arr = $value;
                array_splice($arr, $k, 1);
            @endphp
            <span class="badge badge-secondary font-weight-normal">
                <a href="{{app('request')->create($model->url($model->currentPage()), 'GET', [$key => join(',', $arr)])->getUri()}}" class="text-decoration-none">
                    <i class="fal fa-times align-middle"></i>
                </a>
                {{__(ucfirst($key))}}: {{__(ucfirst($item))}}
            </span>
        @endforeach
    @elseif($model->getFilter($key) instanceof \Illuminate\Database\Eloquent\Model)
        <span class="badge badge-secondary font-weight-normal">
            <a href="{{app('request')->create($model->url($model->currentPage()), 'GET', [$key => null])->getUri()}}" class="text-decoration-none">
                <i class="fal fa-times align-middle"></i>
            </a>
            {{__(ucfirst($key))}}: {{__($model->getFilter($key)->getFilterValue())}}
        </span>
    @elseif(!is_object($value))
        <span class="badge badge-secondary font-weight-normal">
            <a href="{{app('request')->create($model->url($model->currentPage()), 'GET', [$key => null])->getUri()}}" class="text-decoration-none">
                <i class="fal fa-times align-middle"></i>
            </a>
            {{__(ucfirst($key))}}: {{__(ucfirst($value))}}
        </span>
    @endif
@endforeach
