<input type="hidden" name="{{$attributes['name']}}" value="0">
<boolean-input {!!  count($errors) > 0 ? 'error="'.$errors[0].'"':null!!}
@foreach($attributes as $key => $value)
    {!! $key.'="'.$value.'"' !!}
    @endforeach
></boolean-input>
