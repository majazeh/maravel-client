@php
    if (isset($model)) {
        $tag = $model->route('show') ? 'a' : 'span';
        $href = $tag == 'a' ? ' href="'.$model->route('show').'"' : '';
    }
    else{
        $tag = isset($href) ? 'a' : 'span';
        $href = isset($href) ? ' href="' . urldecode($href) . '"' : '';
    }
@endphp
<{!!$tag.$href!!} class="fs-14">
    <i class="far fa-eye"></i>
</{!!$tag!!}>
