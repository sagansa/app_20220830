@php $editing = isset($transferToAccount) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.text
        name="name"
        label="Name"
        value="{{ old('name', ($editing ? $transferToAccount->name : '')) }}"
        maxlength="255"
        required
    ></x-input.text>

    <x-input.text
        name="number"
        label="Number"
        value="{{ old('number', ($editing ? $transferToAccount->number : '')) }}"
        required
    ></x-input.text>

    <x-input.select name="bank_id" label="Bank" required>
        @php $selected = old('bank_id', ($editing ? $transferToAccount->bank_id : '')) @endphp
        <option disabled {{ empty($selected) ? 'selected' : '' }}>-- select --</option>
        @foreach($banks as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
        @endforeach
    </x-input.select>

    <x-input.select name="status" label="Status">
        @php $selected = old('status', ($editing ? $transferToAccount->status : '1')) @endphp
        <option value="1" {{ $selected == '1' ? 'selected' : '' }} >used</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }} >not used</option>
    </x-input.select>

    @if ($editing)
    <x-shows.dl>
        <x-shows.sub-dl>
            <x-shows.dt>Created Date</x-shows.dt>
            <x-shows.dd>{{ $transferToAccount->created_at }} </x-shows.dd>
        </x-shows.sub-dl>
        <x-shows.sub-dl>
            <x-shows.dt>Updated Date</x-shows.dt>
            <x-shows.dd>{{ $transferToAccount->updated_at }} </x-shows.dd>
        </x-shows.sub-dl>
        @role('super-admin|manager|supervisor')
        <x-shows.sub-dl>
            <x-shows.dt>Created By</x-shows.dt>
            <x-shows.dd
                >{{ optional($transferToAccount->created_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole @role('staff|super-admin')
        <x-shows.sub-dl>
            <x-shows.dt>Updated By</x-shows.dt>
            <x-shows.dd
                >{{ optional($transferToAccount->approved_by)->name ?? '-' }}
            </x-shows.dd>
        </x-shows.sub-dl>
        @endrole
    </x-shows.dl>
    @endif
</div>
