@php $editing = isset($invoicePurchase) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.image name="image" label="Image">
        <div
            x-data="imageViewer('{{ $editing && $invoicePurchase->image ? \Storage::url($invoicePurchase->image) : '' }}')"
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

    <x-input.select name="payment_type_id" label="Payment Type" required>
        @php $selected = old('payment_type_id', ($editing ? $invoicePurchase->payment_type_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($paymentTypes as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $invoicePurchase->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($stores as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="supplier_id" label="Supplier" required>
        @php $selected = old('supplier_id', ($editing ? $invoicePurchase->supplier_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($suppliers as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date
        name="date"
        label="Date"
        value="{{ old('date', ($editing ? optional($invoicePurchase->date)->format('Y-m-d') : '')) }}"
        max="255"
        required
    ></x-input.date>

    <x-input.select name="payment_status" label="Payment Status">
        @php $selected = old('payment_status', ($editing ? $invoicePurchase->payment_status : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >belum dibayar</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >sudah dibayar</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >tidak valid</option>
        <option value="4" {{ $selected == '4' ? 'selected' : '' }} >periksa ulang</option>
    </x-input.select>

    <x-input.select name="order_status" label="Order Status">
        @php $selected = old('order_status', ($editing ? $invoicePurchase->order_status : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >belum diterima</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >sudah diterima</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >dikembalikan</option>
    </x-input.select>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $invoicePurchase->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $invoicePurchase->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($invoicePurchase->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($invoicePurchase->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
