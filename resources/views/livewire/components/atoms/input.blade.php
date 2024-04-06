@props([
  'disabled' => false,
  'class' => '',
  'value' => '',
  'name' => '',
  'id' => '',
  'placeholder' => '',
  'type' => 'text',
  'required' => false,
  'autofocus' => false,
  'autocomplete' => 'off'
])

<input
	id="{{ $id }}"
	type="{{ $type }}"
	name="{{ $name }}"
	value="{{ $value }}"
	class="{{ $attributes->merge(['class' => 'input-form ' . $class]) }}"
	placeholder="{{ $placeholder }}"
	{{ $disabled ? 'disabled' : '' }}
	{{ $required ? 'required' : '' }}
	{{ $autofocus ? 'autofocus' : '' }}
	autocomplete="{{ $autocomplete }}"
/>
