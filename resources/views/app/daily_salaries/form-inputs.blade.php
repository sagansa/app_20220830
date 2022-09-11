@php $editing = isset($dailySalary) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.select name="store_id" label="Store" required>
        @php $selected = old('store_id', ($editing ? $dailySalary->store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($stores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="shift_store_id" label="Shift Store" required>
        @php $selected = old('shift_store_id', ($editing ? $dailySalary->shift_store_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach ($shiftStores as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.date name="date" label="Date"
        value="{{ old('date', $editing ? optional($dailySalary->date)->format('Y-m-d') : '') }}" required>
    </x-input.date>

    <x-input.currency name="amount" label="Amount" value="{{ old('amount', $editing ? $dailySalary->amount : '') }}"
        required></x-input.currency>

    @if (!$editing)
        <x-input.select name="payment_type_id" label="Payment Type" required>
            @php $selected = old('payment_type_id', ($editing ? $dailySalary->payment_type_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($paymentTypes as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-input.select>
    @endif

    @if ($editing)
        <x-input.select name="payment_type_id" label="Payment Type" required>
            @php $selected = old('payment_type_id', ($editing ? $dailySalary->payment_type_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
            @foreach ($paymentTypes as $value => $label)
                <option readonly value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </x-input.select>
    @endif

    @role('super-admin|manager')
        <x-input.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $dailySalary->status : '1')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum diperiksa</option>
            <option value="2" {{ $selected == '2' ? 'selected' : '' }}>sudah dibayar</option>
            <option value="3" {{ $selected == '3' ? 'selected' : '' }}>siap dibayar</option>
            <option value="4" {{ $selected == '4' ? 'selected' : '' }}>perbaiki</option>
        </x-input.select>
    @endrole

    @role('staff|supervisor')
        <x-input.hidden name="status" value="{{ old('status', $editing ? $dailySalary->status : '1') }}">
        </x-input.hidden>
    @endrole

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $dailySalary->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $dailySalary->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($dailySalary->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
            @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($dailySalary->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
