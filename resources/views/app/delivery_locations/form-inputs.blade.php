@php $editing = isset($deliveryLocation) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text name="label" label="Label" value="{{ old('label', $editing ? $deliveryLocation->label : '') }}"
        maxlength="255" required></x-input.text>

    <x-input.text name="contact_name" label="Contact Name"
        value="{{ old('contact_name', $editing ? $deliveryLocation->contact_name : '') }}" maxlength="255" required>
    </x-input.text>

    <x-input.text name="contact_number" label="Contact Number"
        value="{{ old('contact_number', $editing ? $deliveryLocation->contact_number : '') }}" maxlength="255" required>
    </x-input.text>

    <x-input.textarea name="Address" label="Address" maxlength="255" required>
        {{ old('Address', $editing ? $deliveryLocation->Address : '') }}</x-input.textarea>


    @role('super-admin')

        <x-input.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $deliveryLocation->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach ($users as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>

        <x-input.select name="province_id" label="Province">
            @php $selected = old('province_id', ($editing ? $deliveryLocation->province_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($provinces as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>

        <x-input.select name="regency_id" label="Regency">
            @php $selected = old('regency_id', ($editing ? $deliveryLocation->regency_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($regencies as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>

        <x-input.select name="district_id" label="District">
            @php $selected = old('district_id', ($editing ? $deliveryLocation->district_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($districts as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>

        <x-input.select name="village_id" label="Village">
            @php $selected = old('village_id', ($editing ? $deliveryLocation->village_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($villages as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>

    @endrole

    @role('customer')
        <x-input.hidden name="user_id" value="{{ old('user_id', $editing ? $deliveryLocation->user_id : '') }}">
        </x-input.hidden>
        <x-input.hidden name="province_id"
            value="{{ old('province_id', $editing ? $deliveryLocation->province_id : '') }}">
        </x-input.hidden>
        <x-input.hidden name="regency_id" value="{{ old('regency_id', $editing ? $deliveryLocation->regency_id : '') }}">
        </x-input.hidden>
        <x-input.hidden name="district_id"
            value="{{ old('district_id', $editing ? $deliveryLocation->district_id : '') }}">
        </x-input.hidden>
        <x-input.hidden name="village_id" value="{{ old('village_id', $editing ? $deliveryLocation->village_id : '') }}">
        </x-input.hidden>
    @endrole

    @if ($editing)
        @role('super-admin|manager')
            <x-shows.dl>
                <x-shows.sub-dl>
                    <x-shows.dt>Created Date</x-shows.dt>
                    <x-shows.dd>{{ $deliveryLocation->created_at }} </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>Updated Date</x-shows.dt>
                    <x-shows.dd>{{ $deliveryLocation->updated_at }} </x-shows.dd>
                </x-shows.sub-dl>
            </x-shows.dl>
        @endrole
    @endif
</div>
