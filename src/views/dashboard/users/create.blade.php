@extends('dashboard.create')
@isset ($user)
    @section('before_content')
    <form action="{{route('dashboard.users.avatar.store', ['user' => $user->id])}}" method="POST">
        <div class="card-body">
            <div class="form-group d-flex">
                <div class="media media-xl rounded-circle">
                    <input type="file" class="hide-input input-avatar" id="avatar" name="avatar">
                    <label for="avatar" class="m-0">
                        <img src="{{$user->avatar_url->url('small')}}" alt="">
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary fs-10" data-alias="avatar">
                {{__('Save avatar')}}
            </button>
        </div>
    </form>
    @endsection
@endisset
@section('form_content')
    <div class="form-group form-group-m">
        <input type="text" class="form-control form-control-m" id="name" name="name" @formValue($user->name) placeholder="&nbsp;" autocomplete="off">
        <label for="name">{{__('Display name')}}</label>
    </div>

    <div class="form-group form-group-m">
        <input type="text" class="form-control form-control-m text-left direction-ltr" id="mobile" name="mobile" @formValue($user->mobile) placeholder="&nbsp;" autocomplete="off">
        <label for="mobile">{{__('Mobile')}}</label>
    </div>

    <div class="form-group form-group-m">
        <input type="text" class="form-control form-control-m text-left direction-ltr" id="username" name="username" @formValue($user->username) placeholder="&nbsp;" autocomplete="off">
        <label for="username">{{__('Username')}}</label>
    </div>
     <div class="form-group form-group-m">
        <input type="text" class="form-control form-control-m text-left direction-ltr" id="email" name="email" @formValue($user->email) placeholder="&nbsp;" autocomplete="off">
        <label for="email">{{__('Email')}}</label>
    </div>
    <div class="form-group form-group-m {{isset($user) && $user->type =='psychologist' ? 'd-none' : ''}}">
        <input type="text" class="form-control form-control-m" id="position" name="position" @if(!isset($user) || (isset($user) && $user->type !='psychologist'))@formValue($user->position) @endif placeholder="&nbsp;" autocomplete="off"  {{isset($user) && $user->type =='psychologist' ? 'disabled' : ''}}>
        <label for="position">{{__('User position')}}</label>
    </div>
    <div class="form-group form-group-m {{(isset($user) && $user->type !='psychologist') || !isset($user) ? 'd-none' : ''}}">
        <select name="position" data-alias="position" id="psychologist-position" {{(isset($user) && $user->type !='psychologist') || !isset($user) ? 'disabled' : ''}} class="form-control form-control-m">
            <option value="supervisor" @selectChecked($user->position, 'supervisor')>{{__('Supervisor')}}</option>
            <option value="therapist" @selectChecked($user->position, 'therapist')>{{__('Therapist')}}</option>
            <option value="under_supervision" @selectChecked($user->position, 'under_supervision')>{{__('Under supervision')}}</option>
        </select>
        <label for="psychologist-position">{{__('User position')}}</label>
    </div>

    <div class="form-group form-group-m">
        <input type="password" class="form-control form-control-m text-left direction-ltr" id="password" name="password"placeholder="&nbsp;" autocomplete="new-password">
        <label for="password">{{__('Password')}}</label>
    </div>

    <div class="form-group mb-0">
        <label>{{__('Status')}}</label>
        <div class="d-flex flex-wrap">
            <div class="richak richak-sm richak-secondary">
                <input type="radio" name="status" id="status-active" value="active" @radioChecked($user->status, 'active')>
                <label for="status-active">
                    <span class="far fa-lightbulb-on richak-icon"></span>
                    {{__('Active')}}
                </label>
            </div>
            <div class="richak richak-sm richak-secondary">
                <input type="radio" name="status" id="status-awaiting" value="awaiting" @radioChecked($user->status, 'awaiting')>
                <label for="status-awaiting">
                    <i class="fal fa-user-clock richak-icon"></i>
                    {{__('Awaiting')}}
                </label>
            </div>
            <div class="richak richak-sm richak-secondary">
                <input type="radio" name="status" id="status-blocked" value="blocked" @radioChecked($user->status, 'blocked')>
                <label for="status-blocked">
                    <i class="fal fa-user-lock richak-icon"></i>
                    {{__('Blocked')}}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group mb-0">
        <label>{{__('User type')}}</label>
        <div class="d-flex flex-wrap user-types">
            <div class="richak richak-sm richak-secondary">
                <input type="radio" name="type" id="type-admin" value="admin" @radioChecked($user->type, 'admin')>
                <label for="type-admin">
                    <span class="far fa-users-crown richak-icon"></span>
                    {{__('Admin')}}
                </label>
            </div>
            <div class="richak richak-sm richak-secondary">
                <input type="radio" name="type" id="type-manager" value="manager" @radioChecked($user->type, 'manager')>
                <label for="type-manager">
                    <i class="fal fa-users-cog richak-icon"></i>
                    {{__('Manager')}}
                </label>
            </div>
            <div class="richak richak-sm richak-secondary">
                <input type="radio" name="type" id="type-operator" value="operator" @radioChecked($user->type, 'operator')>
                <label for="type-operator">
                    <i class="fal fa-user-headset richak-icon"></i>
                    {{__('Operator')}}
                </label>
            </div>
            <div class="richak richak-sm richak-secondary">
                <input type="radio" name="type" id="type-psychologist" value="psychologist" @radioChecked($user->type, 'psychologist')>
                <label for="type-psychologist">
                    <i class="fal fa-user-tie richak-icon"></i>
                    {{__('Psychologist')}}
                </label>
            </div>
            <div class="richak richak-sm richak-secondary">
                <input type="radio" name="type" id="type-client" value="client" @radioChecked($user->type, 'client')>
                <label for="type-client">
                    <i class="far fa-user-shield richak-icon"></i>
                    {{__('Client')}}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group mb-0">
        <label>{{__('Gender')}}</label>
        <div class="d-flex flex-wrap">
            <div class="richak richak-sm richak-secondary">
                <input type="radio" name="gender" id="gender-male" value="male" @radioChecked($user->gender, 'male')>
                <label for="gender-male">
                    <span class="fal fa-male richak-icon"></span>
                    {{__('Male')}}
                </label>
            </div>
            <div class="richak richak-sm richak-secondary">
                <input type="radio" name="gender" id="gender-female" value="female" @radioChecked($user->gender, 'female')>
                <label for="gender-female">
                    <span class="fal fa-female richak-icon"></span>
                    {{__('Female')}}
                </label>
            </div>
        </div>
    </div>
@endsection
