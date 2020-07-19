<div class="form-group form-group-m">
    <input type="text" class="form-control form-control-m" id="name" name="name" placeholder="&nbsp;" autocomplete="off" @formValue($user->name)>
    <label for="name">{{__('Display name')}}</label>
</div>

<div class="form-group form-group-m">
    <input type="text" class="form-control form-control-m text-left direction-ltr" id="mobile" name="mobile" placeholder="&nbsp;" autocomplete="off" @formValue($user->mobile)>
    <label for="mobile">{{__('Mobile')}}</label>
</div>

<div class="form-group form-group-m">
    <input type="text" class="form-control form-control-m text-left direction-ltr" id="username" name="username" placeholder="&nbsp;" autocomplete="off" @formValue($user->username)>
    <label for="username">{{__('Username')}}</label>
</div>
    <div class="form-group form-group-m">
    <input type="text" class="form-control form-control-m text-left direction-ltr" id="email" name="email" placeholder="&nbsp;" autocomplete="off" @formValue($user->email)>
    <label for="email">{{__('Email')}}</label>
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
        @includeFirst(['dashboard.users.createTypes', 'dashboard.users._createTypes'])
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
