@extends('dashboard.create')
@section('form_content')
    <div class="form-group form-group-m">
        <input type="text" class="form-control form-control-m" id="title" name="title" @formValue($term->title) placeholder="&nbsp;" autocomplete="off">
        <label for="name">{{__('Title')}}</label>
    </div>
    @if ($module->action == 'create')
        <div class="form-group form-group-m">
            <select class="select2-select" name="parent_id" id="parent_id" data-url="{{route('dashboard.terms.index')}}">
            </select>
        </div>
    @endif
@endsection
