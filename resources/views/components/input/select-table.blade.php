{{-- <select
    class="block w-full py-1 pl-3 pr-10 my-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
    wire:change="changeStatus({{ $detailRequest }}, $event.target.value)">
    <option value="1" {{ $detailRequest->status == '1' ? 'selected' : '' }}>
        Process</option>
    <option value="2" {{ $detailRequest->status == '2' ? 'selected' : '' }}>
        Done</option>
    <option value="3" {{ $detailRequest->status == '3' ? 'selected' : '' }}>
        Reject</option>
    <option value="4" {{ $detailRequest->status == '4' ? 'selected' : '' }}>
        Approved</option>
    <option value="5" {{ $detailRequest->status == '5' ? 'selected' : '' }}>
        Not Valid</option>
</select> --}}

@props(['wire'])

<select wire:change="{{ $wire }}"
    {{ $attributes->merge([
        'class' =>
            'block w-full py-1 pl-3 pr-10 my-1 text-xs border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500',
    ]) }}>{{ $slot }}
</select>
