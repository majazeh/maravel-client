@php
    $tag = $model->route('show') ? 'a' : 'span';
    $href = $tag == 'a' ? ' href="'.$model->route('show').'"' : '';
@endphp
<{!!$tag.$href!!} class="d-none d-sm-inline">
    <span class="direction-ltr align-left d-inline-block font-weight-bold">{{$id[0]}}<span class="d-none d-lg-inline">-</span>{{$id[1]}}</span>
</{!!$tag!!}>
<{!!$tag.$href!!} class="d-sm-none fs-10">
    {{$id[0]}}{{$id[1]}}
</{!!$tag!!}>
