@php $editing = isset($fuelService) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.image name="image" label="Image">
        <div x-data="imageViewer('{{ $editing && $fuelService->image ? \Storage::url($fuelService->image) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
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

    <x-input.select name="vehicle_id" label="Vehicle">
        @php $selected = old('vehicle_id', ($editing ? $fuelService->vehicle_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($vehicles as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="fuel_service" label="Fuel Service">
        @php $selected = old('fuel_service', ($editing ? $fuelService->fuel_service : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>fuel</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>service</option>
    </x-input.select>

    @role('super-admin|manager')
        <x-input.select name="payment_type_id" label="Payment Type">
            @php $selected = old('payment_type_id', ($editing ? $fuelService->payment_type_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($paymentTypes as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>
    @endrole

    @role('supervisor|staff')
        <x-input.hidden name="status" value="{{ old('status', $editing ? $fuelService->status : '1') }}"></x-input.hidden>
    @endrole

    <x-input.number name="km" label="km" value="{{ old('km', $editing ? $fuelService->km : '') }}">
    </x-input.number>

    <x-input.number name="liter" label="Liter" value="{{ old('liter', $editing ? $fuelService->liter : '') }}">
    </x-input.number>

    <x-input.currency name="amount" label="Amount" value="{{ old('amount', $editing ? $fuelService->amount : '') }}">
    </x-input.currency>

    <x-input.select name="closing_store_id" label="Closing Store">
        @php $selected = old('closing_store_id', ($editing ? $fuelService->closing_store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($closingStores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
            </option>
        @endforeach
    </x-input.select>

    @role('super-admin|manager')
        <x-input.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $fuelService->status : '1')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum dibayar</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>sudah dibayar</option>
            <option value="3" {{ $selected == '3' ? 'selected' : '' }}>siap dibayar</option>
            <option value="4" {{ $selected == '4' ? 'selected' : '' }}>tidak valid</option>
        </x-input.select>
    @endrole

    @role('supervisor|staff')
        <x-input.hidden name="status" value="{{ old('status', $editing ? $fuelService->status : '1') }}"></x-input.hidden>
    @endrole

    <x-input.textarea name="notes" label="Notes" maxlength="255">
        {{ old('notes', $editing ? $fuelService->notes : '') }}</x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $fuelService->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $fuelService->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($fuelService->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                @endrole @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($fuelService->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
