<div class="w-full">
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="province_id"
            label="Province"
            wire:model="selectedProvinceId"
        >
            <option selected>-- select --</option>
            @foreach($allProvinces as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
    @if(!empty($selectedProvinceId))
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="regency_id"
            label="Regency"
            wire:model="selectedRegencyId"
        >
            <option selected>-- select --</option>
            @foreach($allRegencies as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </x-inputs.select> </x-inputs.group
    >@endif @if(!empty($selectedRegencyId))
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="district_id"
            label="District"
            wire:model="selectedDistrictId"
        >
            <option selected>-- select --</option>
            @foreach($allDistricts as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </x-inputs.select> </x-inputs.group
    >@endif
</div>
