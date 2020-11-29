@extends('dashboard.create')

@section('form-tag')
<div class="card-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @if (auth()->isAdmin())
            <li class="nav-item">
                <a class="nav-link direct fs-14" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">{{__('Basic')}}</a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link active direct fs-14" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="personal" aria-selected="false">{{__('Personal')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link direct fs-14" id="change-password-tab" data-toggle="tab" href="#change-password" role="tab" aria-controls="change-password" aria-selected="false">{{__('Change password')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link direct fs-14" id="avatar-tab" data-toggle="tab" href="#avatar" role="tab" aria-controls="avatar" aria-selected="false">{{__('Avatar')}}</a>
        </li>
        @includeIf('dashboard.users.forms.tabList')
    </ul>
    <div class="tab-content" id="myTabContent">
        @if (auth()->isAdmin())
        <div class="tab-pane fade pt-3" id="basic" role="tabpanel" aria-labelledby="basic-tab">
            @includeFirst(['dashboard.users.forms.' . $user->type . '.basic', 'dashboard.users.forms.edit.basic', 'dashboard.users.forms.edit._basic'], ['some' => 'data'])
        </div>
        @endif
        <div class="tab-pane fade pt-3 show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
            @includeFirst(['dashboard.users.forms.' . $user->type . '.personal', 'dashboard.users.forms.edit.personal', 'dashboard.users.forms.edit._personal'], ['some' => 'data'])

        </div>
        <div class="tab-pane fade pt-3" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
            @includeFirst(['dashboard.users.forms.' . $user->type . '.password', 'dashboard.users.forms.edit.password', 'dashboard.users.forms.edit._password'], ['some' => 'data'])
        </div>
        <div class="tab-pane fade pt-3" id="avatar" role="tabpanel" aria-labelledby="avatar-tab">
            @includeFirst(['dashboard.users.forms.' . $user->type . '.avatar', 'dashboard.users.forms.edit.avatar', 'dashboard.users.forms.edit._avatar'], ['some' => 'data'])
        </div>
        @includeIf('dashboard.users.forms.tabContent')
    </div>
</div>
@endsection
