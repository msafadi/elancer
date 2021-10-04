@props([
    'id', 'label', 'name', 'selected' => '', 'options' => []
])

<label for="{{ $id }}">{{ $label }}</label>
<select 
    id="{{ $id }}" 
    name="{{ $name }}" 
    {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
>
    <option></option>
    @foreach ($options as $value => $text)
    <option value="{{ $value }}" @if($value == old($name, $selected)) selected @endif>{{ $text }}</option>
    @endforeach
</select>
@error($name)
<p class="invalid-feedback">{{ $message }}</p>
@enderror