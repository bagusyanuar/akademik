<div class="form-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <input {{ $attributes->merge([
    'class' => 'form-control',
    'id' => $id,
    'name' => $name,
    'value' => old($name)
    ]) }}
    />
</div>
