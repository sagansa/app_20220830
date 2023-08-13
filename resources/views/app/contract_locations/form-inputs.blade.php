@php $editing = isset($contractLocation) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="location_id" label="Location" required>
        @php $selected = old('location_id', ($editing ? $contractLocation->location_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($locations as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date
        name="from_date"
        label="From Date"
        value="{{ old('from_date', ($editing ? optional($contractLocation->from_date)->format('Y-m-d') : '')) }}"
        required
    ></x-input.date>

    <x-input.date
        name="until_date"
        label="Until Date"
        value="{{ old('until_date', ($editing ? optional($contractLocation->until_date)->format('Y-m-d') : '')) }}"
        required
    ></x-input.date>

    <x-input.number
        name="nominal_contract"
        label="Nominal Contract"
        value="{{ old('nominal_contract', ($editing ? $contractLocation->nominal_contract : '')) }}"
        required
    ></x-input.number>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $contractLocation->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $contractLocation->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($contractLocation->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($contractLocation->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
