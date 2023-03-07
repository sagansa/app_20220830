@php $editing = isset($salesOrderDirect) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="order_by_id" label="Order By" required>
        @php $selected = old('order_by_id', ($editing ? $salesOrderDirect->order_by_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($users as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date
        name="delivery_date"
        label="Delivery Date"
        value="{{ old('delivery_date', ($editing ? optional($salesOrderDirect->delivery_date)->format('Y-m-d') : '')) }}"
        max="255"
        required
    ></x-input.date>

    <x-input.select
        name="delivery_service_id"
        label="Delivery Service"
        required
    >
        @php $selected = old('delivery_service_id', ($editing ? $salesOrderDirect->delivery_service_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($deliveryServices as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select
        name="transfer_to_account_id"
        label="Transfer To Account"
        required
    >
        @php $selected = old('transfer_to_account_id', ($editing ? $salesOrderDirect->transfer_to_account_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($transferToAccounts as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.image name="image_transfer" label="Image Transfer">
        <div
            x-data="imageViewer('{{ $editing && $salesOrderDirect->image_transfer ? \Storage::url($salesOrderDirect->image_transfer) : '' }}')"
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
                    name="image_transfer"
                    id="image_transfer"
                    @change="fileChosen"
                />
            </div>

            @error('image_transfer')
            @include('components.inputs.partials.error') @enderror
        </div>
    </x-input.image>

    <x-input.select name="payment_status" label="Payment Status">
        @php $selected = old('payment_status', ($editing ? $salesOrderDirect->payment_status : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >proses validasi</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >valid</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >tidak valid</option>
    </x-input.select>

    <x-input.select name="store_id" label="Store">
        @php $selected = old('store_id', ($editing ? $salesOrderDirect->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($stores as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="submitted_by_id" label="Submitted By">
        @php $selected = old('submitted_by_id', ($editing ? $salesOrderDirect->submitted_by_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($users as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.text
        name="received_by"
        label="Received By"
        value="{{ old('received_by', ($editing ? $salesOrderDirect->received_by : '')) }}"
        maxlength="255"
    ></x-input.text>

    <x-input.image name="sign" label="Sign">
        <div
            x-data="imageViewer('{{ $editing && $salesOrderDirect->sign ? \Storage::url($salesOrderDirect->sign) : '' }}')"
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
                <input type="file" name="sign" id="sign" @change="fileChosen" />
            </div>

            @error('sign') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    <x-input.image name="image_receipt" label="Image Receipt">
        <div
            x-data="imageViewer('{{ $editing && $salesOrderDirect->image_receipt ? \Storage::url($salesOrderDirect->image_receipt) : '' }}')"
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
                    name="image_receipt"
                    id="image_receipt"
                    @change="fileChosen"
                />
            </div>

            @error('image_receipt') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    <x-input.select name="delivery_status" label="Delivery Status">
        @php $selected = old('delivery_status', ($editing ? $salesOrderDirect->delivery_status : '')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >pesanan belum diproses</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >pesanan diproses</option>
        <option value="3" {{ $selected == '3' ? 'selected' : '' }} >siap dikirim</option>
        <option value="4" {{ $selected == '4' ? 'selected' : '' }} >telah dikirim</option>
        <option value="5" {{ $selected == '5' ? 'selected' : '' }} >selesai</option>
    </x-input.select>

    <x-input.number
        name="shipping_cost"
        label="Shipping Cost"
        value="{{ old('shipping_cost', ($editing ? $salesOrderDirect->shipping_cost : '')) }}"
    ></x-input.number>

    <x-input.number
        name="Discounts"
        label="Discounts"
        value="{{ old('Discounts', ($editing ? $salesOrderDirect->Discounts : '')) }}"
        required
    ></x-input.number>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $salesOrderDirect->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $salesOrderDirect->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($salesOrderDirect->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($salesOrderDirect->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
