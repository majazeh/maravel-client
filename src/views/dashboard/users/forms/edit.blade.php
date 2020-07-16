@extends('dashboard.create')
{{-- @section('before_content')
<form action="{{route('dashboard.users.avatar.store', ['user' => $user->id])}}" method="POST">
    <div class="card-body">
        <div class="form-group d-flex">
            <div class="media media-xl rounded-circle">
                <input type="file" class="hide-input input-avatar" id="avatar" name="avatar">
                <label for="avatar" class="m-0">
                    <img src="{{$user->avatar_url->url('small')}}" alt="{{__('Avatar')}}">
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary fs-10" data-alias="avatar">
            {{__('Save avatar')}}
        </button>
    </div>
</form>
@endsection --}}

@section('form-tag')
<div class="card-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active direct fs-14" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">اطلاعات پایه</a>
        </li>
        <li class="nav-item">
            <a class="nav-link direct fs-14" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="false">شخصی‌سازی</a>
        </li>
        <li class="nav-item">
            <a class="nav-link direct fs-14" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">تغییر کلمه عبور</a>
        </li>
        <li class="nav-item">
            <a class="nav-link direct fs-14" id="avatar-tab" data-toggle="tab" href="#avatar" role="tab" aria-controls="avatar" aria-selected="false">تغییر تصویر پروفایل</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active pt-3" id="basic" role="tabpanel" aria-labelledby="basic-tab">
            <div class="form-group form-group-m">
                <input type="text" class="form-control form-control-m" id="name" name="name" @formValue($user->name) placeholder="&nbsp;" autocomplete="off">
                <label for="name">{{__('Registered name')}}</label>
            </div>

            <div class="form-group form-group-m">
                <input type="text" class="form-control form-control-m text-left direction-ltr" id="email" name="email" @formValue($user->email) placeholder="&nbsp;" autocomplete="off">
                <label for="email">{{__('Email')}}</label>
            </div>
            @can('update', $user->center)
            <div class="form-group form-group-m">
                <select class="select2-select form-control form-control-m" data-template="users" name="manager_id" data-title="name id" id="manager_id" data-url="{{route('dashboard.users.index', ['type' => ['psychologist', 'operator']])}}">
                    <option value="{{$user->center->manager->id}}">{{$user->center->manager->name ?: $user->center->manager->id}}</option>
                </select>
                <label for="manager_id">{{__('Manager')}}</label>
            </div>
            @endcan
        </div>
        <div class="tab-pane fade pt-3" id="personal" role="tabpanel" aria-labelledby="personal-tab">2</div>
        <div class="tab-pane fade pt-3" id="password" role="tabpanel" aria-labelledby="password-tab">3</div>
        <div class="tab-pane fade pt-3" id="avatar" role="tabpanel" aria-labelledby="avatar-tab">4</div>
    </div>
</div>
@endsection
