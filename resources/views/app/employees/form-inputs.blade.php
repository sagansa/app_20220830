@php $editing = isset($employee) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.number
        name="identity_no"
        label="Identity No"
        value="{{ old('identity_no', ($editing ? $employee->identity_no : '')) }}"
        required
    ></x-input.number>

    <x-input.text
        name="fullname"
        label="Fullname"
        value="{{ old('fullname', ($editing ? $employee->fullname : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="nickname"
        label="Nickname"
        value="{{ old('nickname', ($editing ? $employee->nickname : '')) }}"
        maxlength="20"
        required
    ></x-input.text>

    <x-input.number
        name="no_telp"
        label="No Telp"
        value="{{ old('no_telp', ($editing ? $employee->no_telp : '')) }}"
        required
    ></x-input.number>

    <x-input.text
        name="birth_place"
        label="Birth Place"
        value="{{ old('birth_place', ($editing ? $employee->birth_place : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.date
        name="birth_date"
        label="Birth Date"
        value="{{ old('birth_date', ($editing ? optional($employee->birth_date)->format('Y-m-d') : '')) }}"
        max="255"
        required
    ></x-input.date>

    <x-input.text
        name="fathers_name"
        label="Fathers Name"
        value="{{ old('fathers_name', ($editing ? $employee->fathers_name : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="mothers_name"
        label="Mothers Name"
        value="{{ old('mothers_name', ($editing ? $employee->mothers_name : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.number
        name="parents_no_telp"
        label="Parents No Telp"
        value="{{ old('parents_no_telp', ($editing ? $employee->parents_no_telp : '')) }}"
        required
    ></x-input.number>

    <x-input.text
        name="address"
        label="Address"
        value="{{ old('address', ($editing ? $employee->address : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.number
        name="codepos"
        label="Codepos"
        value="{{ old('codepos', ($editing ? $employee->codepos : '')) }}"
        required
    ></x-input.number>

    <x-input.text
        name="gps_location"
        label="GPS Location"
        value="{{ old('gps_location', ($editing ? $employee->gps_location : '')) }}"
        maxlength="255"
    ></x-input.text>

    <x-input.text
        name="siblings_name"
        label="Siblings Name"
        value="{{ old('siblings_name', ($editing ? $employee->siblings_name : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.number
        name="siblings_no_telp"
        label="Siblings No Telp"
        value="{{ old('siblings_no_telp', ($editing ? $employee->siblings_no_telp : '')) }}"
        required
    ></x-input.number>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="bpjs"
            label="BPJS"
            :checked="old('bpjs', ($editing ? $employee->bpjs : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-input.text
        name="bank_account_no"
        label="Bank Account No"
        value="{{ old('bank_account_no', ($editing ? $employee->bank_account_no : '')) }}"
        required
    ></x-input.text>

    <x-input.select name="marital_status" label="Marital Status">
        @php $selected = old('marital_status', ($editing ? $employee->marital_status : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >belum menikah</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >menikah</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >duda/janda</option>
    </x-input.select>

    <x-input.select name="bank_id" label="Bank" required>
        @php $selected = old('bank_id', ($editing ? $employee->bank_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($banks as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date
        name="accepted_work_date"
        label="Accepted Work Date"
        value="{{ old('accepted_work_date', ($editing ? optional($employee->accepted_work_date)->format('Y-m-d') : '')) }}"
        max="255"
        required
    ></x-input.date>

    <x-input.text
        name="ttd"
        label="TTD"
        value="{{ old('ttd', ($editing ? $employee->ttd : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.select name="religion" label="Religion">
        @php $selected = old('religion', ($editing ? $employee->religion : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >Islam</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >Kristen</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >Katholik</option>
        <option value="4" {{ $selected == '4' ? 'selected' : '' }} >Hindu</option>
        <option value="5" {{ $selected == '5' ? 'selected' : '' }} >Budha</option>
        <option value="6" {{ $selected == '6' ? 'selected' : '' }} >Kong Hu Chu</option>
    </x-input.select>

    <x-input.select name="gender" label="Gender">
        @php $selected = old('gender', ($editing ? $employee->gender : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >Laki-laki</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >Perempuan</option>
    </x-input.select>

    <x-input.select name="driver_license" label="Driver License">
        @php $selected = old('driver_license', ($editing ? $employee->driver_license : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >A</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >C</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >A dan C</option>
    </x-input.select>

    <x-input.select name="level_of_education" label="Level Of Education">
        @php $selected = old('level_of_education', ($editing ? $employee->level_of_education : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >tidak sekolah</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >SD</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >SMP</option>
        <option value="4" {{ $selected == '4' ? 'selected' : '' }} >SMA/SMK</option>
        <option value="5" {{ $selected == '5' ? 'selected' : '' }} >D1</option>
        <option value="6" {{ $selected == '6' ? 'selected' : '' }} >D3</option>
        <option value="7" {{ $selected == '7' ? 'selected' : '' }} >D4/S1</option>
    </x-input.select>

    <x-input.text
        name="major"
        label="Major"
        value="{{ old('major', ($editing ? $employee->major : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.image name="image_identity_id" label="Image Identity Id">
        <div
            x-data="imageViewer('{{ $editing && $employee->image_identity_id ? \Storage::url($employee->image_identity_id) : '' }}')"
            class="mt-1 sm:mt-0 sm:col-span-2"
        >
            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="image_identity_id"
                    id="image_identity_id"
                    @change="fileChosen"
                />
            </div>

            @error('image_identity_id')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-input.image>

    <x-input.image name="image_selfie" label="Image Selfie">
        <div
            x-data="imageViewer('{{ $editing && $employee->image_selfie ? \Storage::url($employee->image_selfie) : '' }}')"
            class="mt-1 sm:mt-0 sm:col-span-2"
        >
            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="image_selfie"
                    id="image_selfie"
                    @change="fileChosen"
                />
            </div>

            @error('image_selfie') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    <x-input.select name="employee_status_id" label="Employee Status">
        @php $selected = old('employee_status_id', ($editing ? $employee->employee_status_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Employee Status</option>
        @foreach($employeeStatuses as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.textarea name="notes" label="Notes" required
        >{{ old('notes', ($editing ? $employee->notes : ''))
        }}</x-input.textarea
    >

    <x-input.select name="province_id" label="Province">
        @php $selected = old('province_id', ($editing ? $employee->province_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Province</option>
        @foreach($provinces as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="regency_id" label="Regency">
        @php $selected = old('regency_id', ($editing ? $employee->regency_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Regency</option>
        @foreach($regencies as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="district_id" label="District">
        @php $selected = old('district_id', ($editing ? $employee->district_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the District</option>
        @foreach($districts as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $employee->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $employee->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($employee->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($employee->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
