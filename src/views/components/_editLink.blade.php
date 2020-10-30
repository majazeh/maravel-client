@php
    if (isset($model)) {
        $tag = $model->route('edit') ? 'a' : 'span';
        $href = $tag == 'a' ? ' href="'.$model->route('edit').'"' : '';
    }
    else{
        $tag = isset($href) ? 'a' : 'span';
        $href = isset($href) ? ' href="' . urldecode($href) . '"' : '';
    }
@endphp
<{!!$tag.$href!!} class="fs-14">
    <i class="far fa-edit"></i>
</{!!$tag!!}>
