@php $editing = isset($salesOrderEmployee) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $salesOrderEmployee->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.text name="customer" label="Customer"
        value="{{ old('customer', $editing ? $salesOrderEmployee->customer : '') }}" maxlength="255" required>
    </x-input.text>

    <x-input.textarea name="detail_customer" label="Detail Customer" maxlength="255" required>
        {{ old('detail_customer', $editing ? $salesOrderEmployee->detail_customer : '') }}</x-input.textarea>

    <x-input.date name="date" label="Date"
        value="{{ old('date', $editing ? optional($salesOrderEmployee->date)->format('Y-m-d') : '') }}" max="255"
        required></x-input.date>

    <x-input.image name="image" label="Image">
        <div x-data="imageViewer('{{ $editing && $salesOrderEmployee->image ? \Storage::url($salesOrderEmployee->image) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
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
                <input type="file" name="image" id="image" @change="fileChosen" />
            </div>

            @error('image')
                @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    @role('sales')
        @if (!$editing)
            <x-input.hidden name="status" value="{{ old('status', $editing ? $salesOrderEmployee->status : '1') }}">
            </x-input.hidden>
        @else
            <x-input.hidden name="status" value="{{ old('status', $editing ? $salesOrderEmployee->status : '') }}">
            </x-input.hidden>
        @endif
        @elserole('super-admin|manager')
        <x-input.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $salesOrderEmployee->status : '1')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
            <option value="3" {{ $selected == '3' ? 'selected' : '' }}>perbaiki</option>
            <option value="4" {{ $selected == '4' ? 'selected' : '' }}>periksa ulang</option>
        </x-input.select>
    @endrole

    @role('super-admin|manager')
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
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($salesOrderEmployee->user)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            </x-shows.dl>
        @endif
        @elserole('sales')
        @if ($editing)
            <x-shows.dl>
                <x-shows.sub-dl>
                    <x-shows.dt>@lang('crud.sales_order_employees.inputs.status')</x-shows.dt>
                    <x-shows.dd>
                        <x-spans.status-valid class="{{ $salesOrderEmployee->status_badge }}">
                            {{ $salesOrderEmployee->status_name }}</x-spans.status-valid>
                    </x-shows.dd>
                </x-shows.sub-dl>
            </x-shows.dl>
        @endif
    @endrole
</div>
