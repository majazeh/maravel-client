<form action="{{route('dashboard.users.change-password', ['user' => $user->id])}}" method="POST">
    <div class="card-body">
        @if (!auth()->isAdmin())
            <div class="form-group form-group-m">
                <input type="password" class="form-control form-control-m text-left direction-ltr" id="cp-password" name="password" placeholder="&nbsp;" autocomplete="password">
                <label for="cp-password">{{__('Current password')}}</label>
            </div>
        @endif
        <div class="form-group form-group-m">
            <input type="password" class="form-control form-control-m text-left direction-ltr" id="cp-new-password" name="new_password" placeholder="&nbsp;" autocomplete="password">
            <label for="cp-new-password">{{__('New password')}}</label>
        </div>
        <button type="submit" class="btn btn-primary">
            {{__('Change password')}}
        </button>
    </div>
</form>
