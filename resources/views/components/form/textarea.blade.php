<div class="form-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <textarea
        {{ $attributes->merge([
    'class' => 'form-control',
    'id' => $id,
    'name' => $name,
    ]) }}
    >{{ $slot }}</textarea>
</div>
