@foreach (config('users.types', []) as $type => $options)
    <div class="richak richak-sm richak-secondary">
    <input type="radio" name="type" id="type-{{$type}}" value="{{$type}}" @radioChecked($user->type, $type)>
    <label for="type-{{$type}}">
        <span class="{{$options['icon']}} richak-icon"></span>
        {{__(ucfirst($type))}}
    </label>
</div>
@endforeach
