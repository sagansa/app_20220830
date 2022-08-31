@props(['id', 'name', 'label', 'value', 'checked' => false, 'addHiddenValue' => true, 'hiddenValue' => 0])

@php
$checked = !!$checked;
@endphp

<div class="relative block mb-2">

    {{-- Adds a hidden default value to be send if checked is false --}}
    @if ($addHiddenValue)
        <input type="hidden" id="{{ $id ?? $name }}-hidden" name="{{ $name }}" value="{{ $hiddenValue }}">
    @endif

    <input type="checkbox" id="{{ $id ?? $name }}" name="{{ $name }}" value="{{ $value ?? 1 }}"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500']) }}>

    @if ($label ?? null)
        <label class="pl-2 text-xs text-gray-700" for="{{ $id ?? $name }}">
            {{ $label }}
        </label>
    @endif
</div>

@error($name)
    @include('components.inputs.partials.error')
@enderror
