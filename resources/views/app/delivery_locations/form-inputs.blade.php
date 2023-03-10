@php $editing = isset($deliveryLocation) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text name="name" label="Name" value="{{ old('name', $editing ? $deliveryLocation->name : '') }}"
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
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Province</option>
            @foreach ($provinces as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>

        <x-input.select name="regency_id" label="Regency">
            @php $selected = old('regency_id', ($editing ? $deliveryLocation->regency_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Regency</option>
            @foreach ($regencies as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>

        <x-input.select name="district_id" label="District">
            @php $selected = old('district_id', ($editing ? $deliveryLocation->district_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the District</option>
            @foreach ($districts as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>

        <x-input.select name="village_id" label="Village">
            @php $selected = old('village_id', ($editing ? $deliveryLocation->village_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Village</option>
            @foreach ($villages as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>

    @endrole

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $deliveryLocation->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $deliveryLocation->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($deliveryLocation->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                @endrole @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($deliveryLocation->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
