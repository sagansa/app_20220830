@php $editing = isset($location) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text
        name="name"
        label="Name"
        value="{{ old('name', ($editing ? $location->name : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $location->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($stores as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.textarea name="address" label="Address" maxlength="255" required
        >{{ old('address', ($editing ? $location->address : ''))
        }}</x-input.textarea
    >

    <x-input.text
        name="contact_person_name"
        label="Contact Person Name"
        value="{{ old('contact_person_name', ($editing ? $location->contact_person_name : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="contact_person_number"
        label="Contact Person Number"
        value="{{ old('contact_person_number', ($editing ? $location->contact_person_number : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.select name="village_id" label="Village">
        @php $selected = old('village_id', ($editing ? $location->village_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($villages as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.number
        name="codepos"
        label="Codepos"
        value="{{ old('codepos', ($editing ? $location->codepos : '')) }}"
    ></x-input.number>

    <x-input.select name="province_id" label="Province">
        @php $selected = old('province_id', ($editing ? $location->province_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($provinces as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="regency_id" label="Regency">
        @php $selected = old('regency_id', ($editing ? $location->regency_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($regencies as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="district_id" label="District">
        @php $selected = old('district_id', ($editing ? $location->district_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($districts as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $location->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $location->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($location->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($location->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
