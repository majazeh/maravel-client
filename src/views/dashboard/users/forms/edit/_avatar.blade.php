<form action="{{route('dashboard.users.avatar.store', ['user' => $user->id])}}" method="POST">
    <div class="card-body text-center">
        <div class="form-group d-flex">
            <div class="media media-xl rounded-circle mx-auto">
                <input type="file" class="hide-input input-avatar" id="avatar-file" name="avatar">
                <label for="avatar-file" class="m-0">
                    <img src="{{$user->avatar_url->url('small')}}" alt="{{__('Avatar')}}">
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary fs-10" data-alias="avatar">
            {{__('Save avatar')}}
        </button>
    </div>
</form>
