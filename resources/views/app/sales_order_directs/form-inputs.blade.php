@php $editing = isset($salesOrderDirect) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    @role('super-admin')
        <x-input.select name="order_by_id" label="Order By">
            @php $selected = old('order_by_id', ($editing ? $salesOrderDirect->order_by_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($users as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </x-input.select>
    @endrole

    @role('super-admin|manager|customer')
        <x-input.date name="delivery_date" label="Delivery Date"
            value="{{ old('delivery_date', $editing ? optional($salesOrderDirect->delivery_date)->format('Y-m-d') : '') }}"
            max="255" required></x-input.date>

        <x-input.select name="delivery_service_id" label="Delivery Service" required>
            @php $selected = old('delivery_service_id', ($editing ? $salesOrderDirect->delivery_service_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($deliveryServices as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </x-input.select>

        <x-input.select name="delivery_location_id" label="Delivery Location">
            @php $selected = old('delivery_location_id', ($editing ? $salesOrderDirect->delivery_location_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($deliveryLocations as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>


        <x-input.select name="transfer_to_account_id" label="Transfer To Account" required>
            @php $selected = old('transfer_to_account_id', ($editing ? $salesOrderDirect->transfer_to_account_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($transferToAccounts as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>
    @endrole

    @role('super-admin|manager')
        <x-input.select name="payment_status" label="Payment Status">
            @php $selected = old('payment_status', ($editing ? $salesOrderDirect->payment_status : '1')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }}>proses validasi</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
            <option value="3" {{ $selected == '3' ? 'selected' : '' }}>tidak valid</option>
        </x-input.select>
    @endrole

    @role('customer')
        @if (!$editing)
            <x-input.hidden name="payment_status"
                value="{{ old('payment_status', $editing ? $salesOrderDirect->payment_status : '1') }}">
            </x-input.hidden>
        @else
            <x-input.hidden name="payment_status"
                value="{{ old('payment_status', $editing ? $salesOrderDirect->payment_status : '') }}">
            </x-input.hidden>
        @endif
    @endrole

    @role('super-admin|manager|customer')
        <x-input.image name="image_transfer" label="Image Transfer">
            <div x-data="imageViewer('{{ $editing && $salesOrderDirect->image_transfer ? \Storage::url($salesOrderDirect->image_transfer) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
                <!-- Show the image -->
                <template x-if="imageUrl">
                    <img :src="imageUrl" class="object-cover border border-gray-200 rounded"
                        style="width: 100px; height: 100px;" />
                </template>

                <!-- Show the gray box when image is not available -->
                <template x-if="!imageUrl">
                    <div class="bg-gray-100 border border-gray-200 rounded" style="width: 100px; height: 100px;"></div>
                </template>

                <div class="mt-2">
                    <input type="file" name="image_transfer" id="image_transfer" @change="fileChosen" />
                </div>

                @error('image_transfer')
                    @include('components.inputs.partials.error')
                @enderror
            </div>
        </x-input.image>
    @endrole

    @role('super-admin|manager|storage-staff')
        <x-input.select name="store_id" label="Store">
            @php $selected = old('store_id', ($editing ? $salesOrderDirect->store_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($stores as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>
    @endrole

    @role('super-admin|manager')
        <x-input.select name="submitted_by_id" label="Submitted By">
            @php $selected = old('submitted_by_id', ($editing ? $salesOrderDirect->submitted_by_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($users as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>
    @endrole

    @role('super-admin|manager|storage-staff')
        <x-input.text name="received_by" label="Received By"
            value="{{ old('received_by', $editing ? $salesOrderDirect->received_by : '') }}" maxlength="255">
        </x-input.text>

        <x-input.select name="delivery_status" label="Delivery Status">
            @php $selected = old('delivery_status', ($editing ? $salesOrderDirect->delivery_status : '1')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diproses</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>diproses</option>
            <option value="3" {{ $selected == '3' ? 'selected' : '' }}>siap dikirim</option>
            <option value="4" {{ $selected == '4' ? 'selected' : '' }}>telah dikirim</option>
            <option value="5" {{ $selected == '5' ? 'selected' : '' }}>selesai</option>
            <option value="6" {{ $selected == '6' ? 'selected' : '' }}>dikembalikan</option>
            <option value="7" {{ $selected == '7' ? 'selected' : '' }}>batal</option>
        </x-input.select>
    @endrole

    @role('customer')
        @if (!$editing)
            <x-input.hidden name="delivery_status"
                value="{{ old('delivery_status', $editing ? $salesOrderDirect->delivery_status : '1') }}">
            </x-input.hidden>
        @else
            <x-input.hidden name="delivery_status"
                value="{{ old('delivery_status', $editing ? $salesOrderDirect->delivery_status : '') }}">
            </x-input.hidden>
        @endif
    @endrole

    <x-input.textarea name="notes" label="Notes" maxlength="255">
        {{ old('notes', $editing ? $salesOrderDirect->notes : '') }}</x-input.textarea>

    @role('super-admin|manager|storage-staff')
        <x-input.image name="image_receipt" label="Image Receipt">
            <div x-data="imageViewer('{{ $editing && $salesOrderDirect->image_receipt ? \Storage::url($salesOrderDirect->image_receipt) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
                <!-- Show the image -->
                <template x-if="imageUrl">
                    <img :src="imageUrl" class="object-cover border border-gray-200 rounded"
                        style="width: 100px; height: 100px;" />
                </template>

                <!-- Show the gray box when image is not available -->
                <template x-if="!imageUrl">
                    <div class="bg-gray-100 border border-gray-200 rounded" style="width: 100px; height: 100px;"></div>
                </template>

                <div class="mt-2">
                    <input type="file" name="image_receipt" id="image_receipt" @change="fileChosen" />
                </div>

                @error('image_receipt')
                    @include('components.inputs.partials.error')
                @enderror
            </div>
        </x-input.image>
    @endrole

    @role('super-admin|manager')
        <x-input.image name="sign" label="Sign">
            <div x-data="imageViewer('{{ $editing && $salesOrderDirect->sign ? \Storage::url($salesOrderDirect->sign) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
                <!-- Show the image -->
                <template x-if="imageUrl">
                    <img :src="imageUrl" class="object-cover border border-gray-200 rounded"
                        style="width: 100px; height: 100px;" />
                </template>

                <!-- Show the gray box when image is not available -->
                <template x-if="!imageUrl">
                    <div class="bg-gray-100 border border-gray-200 rounded" style="width: 100px; height: 100px;"></div>
                </template>

                <div class="mt-2">
                    <input type="file" name="sign" id="sign" @change="fileChosen" />
                </div>

                @error('sign')
                    @include('components.inputs.partials.error')
                @enderror
            </div>
        </x-input.image>
    @endrole

    @if (!$editing)
        <x-input.hidden name="shipping_cost"
            value="{{ old('shipping_cost', $editing ? $salesOrderDirect->shipping_cost : '0') }}">
        </x-input.hidden>
        <x-input.hidden name="discounts"
            value="{{ old('discounts', $editing ? $salesOrderDirect->discounts : '0') }}">
        </x-input.hidden>
    @endif

    @role('super-admin|manager')
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
            </x-shows.dl>
        @endif
    @endrole

    @role('storage-staff')
        @if ($editing)
            <x-input.hidden name="delivery_date"
                value="{{ old('delivery_date', $editing ? $salesOrderDirect->delivery_date : '') }}">
            </x-input.hidden>
            <x-input.hidden name="delivery_service_id"
                value="{{ old('delivery_service_id', $editing ? $salesOrderDirect->delivery_service_id : '') }}">
            </x-input.hidden>
            <x-input.hidden name="transfer_to_account_id"
                value="{{ old('transfer_to_account_id', $editing ? $salesOrderDirect->transfer_to_account_id : '') }}">
            </x-input.hidden>
            <x-input.hidden name="payment_status"
                value="{{ old('payment_status', $editing ? $salesOrderDirect->payment_status : '') }}">
            </x-input.hidden>

            <x-shows.dl>
                <x-shows.sub-dl>
                    <x-shows.dt>Order By</x-shows.dt>
                    <x-shows.dd>{{ $salesOrderDirect->order_by->name }} </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>Delivery Date</x-shows.dt>
                    <x-shows.dd>{{ $salesOrderDirect->delivery_date->toFormattedDate() }} </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>@lang('crud.sales_order_directs.inputs.delivery_service_id')</x-shows.dt>
                    <x-shows.dd>{{ optional($salesOrderDirect->deliveryService)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>@lang('crud.sales_order_directs.inputs.delivery_location_id')</x-shows.dt>
                    <x-shows.dd>
                        {{ optional($salesOrderDirect->deliveryLocation)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            </x-shows.dl>
        @endif
    @endrole

    @role('customer')
        @if ($editing)
            <x-shows.dl>

                <x-shows.sub-dl>
                    <x-shows.dt>Payment Status</x-shows.dt>
                    <x-shows.dd>
                        <x-spans.status-valid class="{{ $salesOrderDirect->payment_status_badge }}">
                            {{ $salesOrderDirect->payment_status_name }}
                        </x-spans.status-valid>
                    </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>Delivery Status</x-shows.dt>
                    <x-shows.dd>
                        <x-spans.status-valid class="{{ $salesOrderDirect->delivery_status_badge }}">
                            {{ $salesOrderDirect->delivery_status_name }}
                        </x-spans.status-valid>
                    </x-shows.dd>
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>@lang('crud.sales_order_directs.inputs.image_receipt')</x-shows.dt>
                    @if ($salesOrderDirect->image_receipt != null)
                        <x-partials.thumbnail src="" size="150" />
                    @else
                        <a href="{{ \Storage::url($salesOrderDirect->image_receipt) }}">
                            <x-partials.thumbnail
                                src="{{ $salesOrderDirect->image_receipt ? \Storage::url($salesOrderDirect->image_receipt) : '' }}"
                                size="150" />
                        </a>
                    @endif
                </x-shows.sub-dl>
                <x-shows.sub-dl>
                    <x-shows.dt>Recieved By</x-shows.dt>
                    <x-shows.dd>{{ $salesOrderDirect->received_by }} </x-shows.dd>
                </x-shows.sub-dl>
            </x-shows.dl>
        @endif
    @endrole
</div>
