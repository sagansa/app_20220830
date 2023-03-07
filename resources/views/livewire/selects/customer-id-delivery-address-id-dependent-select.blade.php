<div class="w-full">
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="customer_id"
            label="Customer"
            wire:model="selectedCustomerId"
        >
            <option selected>-- select --</option>
            @foreach($allCustomers as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
    @if(!empty($selectedCustomerId))
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="delivery_address_id"
            label="Delivery Address"
            wire:model="selectedDeliveryAddressId"
        >
            <option selected>-- select --</option>
            @foreach($allDeliveryAddresses as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </x-inputs.select> </x-inputs.group
    >@endif
</div>
