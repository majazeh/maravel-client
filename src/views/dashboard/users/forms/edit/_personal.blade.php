<form action="{{route('dashboard.users.update', ['user' => $user->id])}}" method="POST">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="card-body">
        <div class="form-group form-group-m">
            <input type="text" class="form-control form-control-m" id="p-name" name="name" placeholder="&nbsp;" autocomplete="off" @formValue($user->name)>
            <label for="p-name">{{__('Display name')}}</label>
        </div>

        {{-- <div class="form-group form-group-m">
            <input type="text" class="form-control form-control-m text-left direction-ltr" id="p-mobile" name="mobile" placeholder="&nbsp;" autocomplete="off" @formValue($user->mobile)>
            <label for="p-mobile">{{__('Mobile')}}</label>
        </div> --}}

        <div class="form-group form-group-m">
            <input type="text" class="form-control form-control-m text-left direction-ltr" id="p-username" name="username" placeholder="&nbsp;" autocomplete="off" @formValue($user->username)>
            <label for="p-username">{{__('Username')}}</label>
        </div>
            <div class="form-group form-group-m">
            <input type="text" class="form-control form-control-m text-left direction-ltr" id="p-email" name="email" placeholder="&nbsp;" autocomplete="off" @formValue($user->email)>
            <label for="p-email">{{__('Email')}}</label>
        </div>

        <div class="form-group mb-0">
            <label>{{__('Gender')}}</label>
            <div class="d-flex flex-wrap">
                <div class="richak richak-sm richak-secondary">
                    <input type="radio" name="gender" id="p-gender-male" value="male" @radioChecked($user->gender, 'male')>
                    <label for="p-gender-male">
                        <span class="fal fa-male richak-icon"></span>
                        {{__('Male')}}
                    </label>
                </div>
                <div class="richak richak-sm richak-secondary">
                    <input type="radio" name="gender" id="p-gender-female" value="female" @radioChecked($user->gender, 'female')>
                    <label for="p-gender-female">
                        <span class="fal fa-female richak-icon"></span>
                        {{__('Female')}}
                    </label>
                </div>
            </div>
        </div>
        @yield('custom-personal')
        <button type="submit" class="btn btn-primary fs-10">
            {{__('Save personal profile data')}}
        </button>
    </div>
</form>
