<form action="{{route('dashboard.users.update', ['user' => $user->id])}}" method="POST">
    @method('PUT')
    <div class="card-body">
        @include('dashboard.users.forms.basic')
        <button type="submit" class="btn btn-primary fs-10">
            {{__('Edit Basic profile')}}
        </button>
    </div>
</form>
