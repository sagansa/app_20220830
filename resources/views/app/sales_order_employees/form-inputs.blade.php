@php $editing = isset($salesOrderEmployee) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $salesOrderEmployee->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($stores as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="customer_id" label="Customer" required>
        @php $selected = old('customer_id', ($editing ? $salesOrderEmployee->customer_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($customers as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select
        name="delivery_address_id"
        label="Delivery Address"
        required
    >
        @php $selected = old('delivery_address_id', ($editing ? $salesOrderEmployee->delivery_address_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($deliveryAddresses as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date
        name="date"
        label="Date"
        value="{{ old('date', ($editing ? optional($salesOrderEmployee->date)->format('Y-m-d') : '')) }}"
        max="255"
        required
    ></x-input.date>

    <x-input.number
        name="total"
        label="Total"
        value="{{ old('total', ($editing ? $salesOrderEmployee->total : '')) }}"
        required
    ></x-input.number>

    <x-input.image name="image" label="Image">
        <div
            x-data="imageViewer('{{ $editing && $salesOrderEmployee->image ? \Storage::url($salesOrderEmployee->image) : '' }}')"
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
                    name="image"
                    id="image"
                    @change="fileChosen"
                />
            </div>

            @error('image') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    <x-input.select name="status" label="Status">
        @php $selected = old('status', ($editing ? $salesOrderEmployee->status : '')) @endphp
    </x-input.select>

    <x-input.select name="notes" label="Notes">
        @php $selected = old('notes', ($editing ? $salesOrderEmployee->notes : '')) @endphp
    </x-input.select>

    <x-input.select name="created_by_id" label="Created By">
        @php $selected = old('created_by_id', ($editing ? $salesOrderEmployee->created_by_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
        @foreach($users as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="approved_by_id" label="Updated By">
        @php $selected = old('approved_by_id', ($editing ? $salesOrderEmployee->approved_by_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
        @foreach($users as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-inputs.hidden
        name="status"
        :value="old('status', ($editing ? $salesOrderEmployee->status : ''))"
    ></x-inputs.hidden>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $salesOrderEmployee->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $salesOrderEmployee->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($salesOrderEmployee->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($salesOrderEmployee->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
