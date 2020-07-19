<form action="{{route('dashboard.users.change-password', ['user' => $user->id])}}" method="POST">
    <div class="card-body">
        @include('dashboard.users.forms.basic')
        <button type="submit" class="btn btn-primary fs-10">
            {{__('Edit Basic profile')}}
        </button>
    </div>
</form>
