@php $editing = isset($presence) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $presence->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($stores as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="shift_store_id" label="Shift Store" required>
        @php $selected = old('shift_store_id', ($editing ? $presence->shift_store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($shiftStores as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date
        name="date_in"
        label="Date In"
        value="{{ old('date_in', ($editing ? optional($presence->date_in)->format('Y-m-d') : '')) }}"
        max="255"
        required
    ></x-input.date>

    <x-inputs.group class="w-full">
        <x-inputs.datetime
            name="time_in"
            label="Time In"
            value="{{ old('time_in', ($editing ? optional($presence->time_in)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
            required
        ></x-inputs.datetime>
    </x-inputs.group>

    <x-input.number
        name="latitude_in"
        label="Latitude In"
        value="{{ old('latitude_in', ($editing ? $presence->latitude_in : '')) }}"
        max="255"
        step="0.01"
        required
    ></x-input.number>

    <x-input.number
        name="longitude_in"
        label="Longitude In"
        value="{{ old('longitude_in', ($editing ? $presence->longitude_in : '')) }}"
        max="255"
        step="0.01"
        required
    ></x-input.number>

    <x-input.image name="image_in" label="Image In">
        <div
            x-data="imageViewer('{{ $editing && $presence->image_in ? \Storage::url($presence->image_in) : '' }}')"
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
                    name="image_in"
                    id="image_in"
                    @change="fileChosen"
                />
            </div>

            @error('image_in') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    <x-input.select name="created_by_id" label="Created By">
        @php $selected = old('created_by_id', ($editing ? $presence->created_by_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
        @foreach($users as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="approved_by_id" label="Approved By">
        @php $selected = old('approved_by_id', ($editing ? $presence->approved_by_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
        @foreach($users as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date
        name="date_out"
        label="Date Out"
        value="{{ old('date_out', ($editing ? optional($presence->date_out)->format('Y-m-d') : '')) }}"
        max="255"
        required
    ></x-input.date>

    <x-inputs.group class="w-full">
        <x-inputs.datetime
            name="time_out"
            label="Time Out"
            value="{{ old('time_out', ($editing ? optional($presence->time_out)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
        ></x-inputs.datetime>
    </x-inputs.group>

    <x-input.number
        name="latitude_out"
        label="Latitude Out"
        value="{{ old('latitude_out', ($editing ? $presence->latitude_out : '')) }}"
        max="255"
        step="0.01"
    ></x-input.number>

    <x-input.number
        name="longitude_out"
        label="Longitude Out"
        value="{{ old('longitude_out', ($editing ? $presence->longitude_out : '')) }}"
        max="255"
        step="0.01"
    ></x-input.number>

    <x-input.image name="image_out" label="Image Out">
        <div
            x-data="imageViewer('{{ $editing && $presence->image_out ? \Storage::url($presence->image_out) : '' }}')"
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
                    name="image_out"
                    id="image_out"
                    @change="fileChosen"
                />
            </div>

            @error('image_out') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    <x-input.select name="status" label="Status">
        @php $selected = old('status', ($editing ? $presence->status : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >belum valid</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >valid</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >tidak valid</option>
    </x-input.select>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $presence->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $presence->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($presence->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($presence->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
