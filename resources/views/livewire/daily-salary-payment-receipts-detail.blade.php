<div>
    <div>
        @can('create', App\Models\PaymentReceipt::class)
        <button class="button" wire:click="newPaymentReceipt">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.attach')
        </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-input.select
                        name="payment_receipt_id"
                        label="Payment Receipt"
                        wire:model="payment_receipt_id"
                    >
                        <option value="null" disabled>-- select --</option>
                        @foreach($paymentReceiptsForSelect as $value => $label)
                        <option value="{{ $value }}"  >{{ $label }}</option>
                        @endforeach
                    </x-input.select>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModal')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.daily_salary_payment_receipts.inputs.payment_receipt_id')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($dailySalaryPaymentReceipts as $paymentReceipt)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        {{ $paymentReceipt->image ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 70px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('delete-any', App\Models\PaymentReceipt::class)
                            <button
                                class="button button-danger"
                                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                wire:click="detach({{ $paymentReceipt->id }})"
                            >
                                <i
                                    class="mr-1 icon ion-md-trash text-primary"
                                ></i>
                                @lang('crud.common.detach')
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <div class="mt-10 px-4">
                            {{ $dailySalaryPaymentReceipts->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
