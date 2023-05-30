@props([
'options' , 'name' , 'checked'=> false
])

@foreach($options as $value => $text)

<div class="form-check">
    <input name="{{$name}}" type="radio" value="{{$value}}" @checked(old($name ,$checked)==$value) {{ $attributes->class([
    'form-check-input',
    'is-invalid'=>$errors->has($name)
    ])}}>
    <label class="form-check-label">
        {{$text}}
    </label>
</div>
@endforeach
@error($name)
<div class="text-danger">
    {{$message}}
</div>
@enderror