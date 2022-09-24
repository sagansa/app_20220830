@php $editing = isset($paymentReceipt) @endphp

<div class="mt-6 space-y-6 sm:mt-5 sm:space-y-5">
    <x-input.image name="image" label="Image">
        <div x-data="imageViewer('{{ $editing && $paymentReceipt->image ? \Storage::url($paymentReceipt->image) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
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

    @if (!$editing)
        <x-input.hidden name="amount" value="{{ old('amount', $editing ? $paymentReceipt->amount : '0') }}">
        </x-input.hidden>
    @else
        <x-input.hidden name="amount" value="{{ old('amount', $editing ? $paymentReceipt->amount : '') }}">
        </x-input.hidden>
    @endif

    <x-input.select name="payment_for" label="Payment For">
        @php $selected = old('payment_for', ($editing ? $paymentReceipt->payment_for : '3')) @endphp
        <option value="3" {{ $selected == '3' ? 'selected' : '' }}>invoice purchase</option>
        <option value="1" {{ $selected == '1' ? 'selected' : '' }}>fuel service</option>
        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>daily salary</option>
    </x-input.select>

    <x-input.image name="image_adjust" label="Additional">
        <div x-data="imageViewer('{{ $editing && $paymentReceipt->image_adjust ? \Storage::url($paymentReceipt->image_adjust) : '' }}')" class="mt-1 sm:mt-0 sm:col-span-2">
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
                <input type="file" name="image_adjust" id="image_adjust" @change="fileChosen" />
            </div>

            @error('image_adjust')
                @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-input.image>

    <x-input.textarea name="notes" label="Notes" maxlength="255">
        {{ old('notes', $editing ? $paymentReceipt->notes : '') }}</x-input.textarea>

    @if ($editing)
        <x-shows.dl>
            <x-shows.sub-dl>
                <x-shows.dt>Created Date</x-shows.dt>
                <x-shows.dd>{{ $paymentReceipt->created_at }} </x-shows.dd>
            </x-shows.sub-dl>
            <x-shows.sub-dl>
                <x-shows.dt>Updated Date</x-shows.dt>
                <x-shows.dd>{{ $paymentReceipt->updated_at }} </x-shows.dd>
            </x-shows.sub-dl>
            @role('super-admin|manager|supervisor')
                <x-shows.sub-dl>
                    <x-shows.dt>Created By</x-shows.dt>
                    <x-shows.dd>{{ optional($paymentReceipt->created_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
                @endrole @role('staff|super-admin')
                <x-shows.sub-dl>
                    <x-shows.dt>Updated By</x-shows.dt>
                    <x-shows.dd>{{ optional($paymentReceipt->approved_by)->name ?? '-' }}
                    </x-shows.dd>
                </x-shows.sub-dl>
            @endrole
        </x-shows.dl>
    @endif
</div>
