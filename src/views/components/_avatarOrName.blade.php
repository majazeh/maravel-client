@if ($_avatar = $_userAvatar->avatar_url->get('small'))
    <img src="{{$_avatar->url}}" class="rounded-circle">
@else
    {{$_userAvatar->shortName}}
@endif
