@foreach($model->response('meta')->filters->current as $key => $value)
<span class="badge badge-secondary font-weight-normal">
    <a href="{{app('request')->create($model->url($model->currentPage()), 'GET', [$key => null])->getUri()}}" class="text-decoration-none">
        <i class="fal fa-times align-middle"></i>
    </a>
    {{__(ucfirst($key))}}: {{__(ucfirst(is_string($value) ? $value : $value))}}
</span>
@endforeach
