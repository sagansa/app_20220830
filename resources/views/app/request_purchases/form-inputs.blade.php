@php $editing = isset($requestPurchase) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $requestPurchase->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date name="date" label="Date"
        value="{{ old('date', $editing ? optional($requestPurchase->date)->format('Y-m-d') : '') }}" required>
    </x-input.date>

    @role('manager|supervisor|super-admin')
        <x-input.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $requestPurchase->status : '1')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }}>process</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>done</option>
        </x-input.select>
    @endrole
    @role('manager|supervisor|staff')
        <x-input.hidden name="status" value="{{ old('status', $editing ? $requestPurchase->status : '1') }}">
        </x-input.hidden>
    @endrole

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created By</x-shows.dt>
                <x-shows.dd>{{ $requestPurchase->user->name }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $requestPurchase->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $requestPurchase->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
        </x-shows.dl>
    @endif
</div>
