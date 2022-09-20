<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $editing ? 'Edit Sales Order Online' : 'Create Sales Order Online' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form wire:submit.prevent="save">
                        @csrf

                        <div>
                            <x-inputs.group class="w-full">
                                <div image-url="{{ $editing && $salesOrderOnline->image ? \Storage::url($salesOrderOnline->image) : '' }}"
                                    x-data="imageViewer()" @refresh.window="refreshUrl()">
                                    <x-inputs.partials.label name="salesOrderOnlineImage" label="Image">
                                    </x-inputs.partials.label><br />

                                    <!-- Show the image -->
                                    <template x-if="imageUrl">
                                        <img :src="imageUrl" class="object-cover border border-gray-200 rounded "
                                            style="width: 100px; height: 100px;" />
                                    </template>

                                    <!-- Show the gray box when image is not available -->
                                    <template x-if="!imageUrl">
                                        <div class="bg-gray-100 border border-gray-200 rounded "
                                            style="width: 100px; height: 100px;"></div>
                                    </template>

                                    <div class="mt-2">
                                        <input type="file" name="salesOrderOnlineImage"
                                            id="salesOrderOnlineImage{{ $uploadIteration }}"
                                            wire:model="salesOrderOnlineImage" @change="fileChosen" />
                                    </div>

                                    @error('salesOrderOnlineImage')
                                        @include('components.inputs.partials.error')
                                    @enderror
                                </div>
                            </x-inputs.group>

                            <x-inputs.group class="w-full">
                                <x-inputs.select name="salesOrderOnline.store_id" label="Store"
                                    wire:model="salesOrderOnline.store_id">
                                    <option value="null" disabled>-- select --</option>
                                    @foreach ($storesForSelect as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </x-inputs.select>
                            </x-inputs.group>

                            <x-inputs.group class="w-full">
                                <x-inputs.select name="salesOrderOnline.online_shop_provider_id"
                                    label="Online Shop Provider" wire:model="salesOrderOnline.online_shop_provider_id">
                                    <option value="null" disabled>-- select --</option>
                                    @foreach ($onlineShopProvidersForSelect as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </x-inputs.select>
                            </x-inputs.group>

                            <x-inputs.group class="w-full">
                                <x-inputs.select name="salesOrderOnline.delivery_service_id" label="Delivery Service"
                                    wire:model="salesOrderOnline.delivery_service_id">
                                    <option value="null" disabled>-- select --</option>
                                    @foreach ($deliveryServicesForSelect as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </x-inputs.select>
                            </x-inputs.group>

                            <x-inputs.group class="w-full">
                                <x-inputs.date name="salesOrderOnlineDate" label="Date"
                                    wire:model="salesOrderOnlineDate" max="255"></x-inputs.date>
                            </x-inputs.group>

                            <x-inputs.group class="w-full">
                                <x-inputs.select name="salesOrderOnline.customer_id" label="Customer"
                                    wire:model="salesOrderOnline.customer_id">
                                    <option value="null" disabled>-- select --</option>
                                    @foreach ($customersForSelect as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </x-inputs.select>
                            </x-inputs.group>

                            <x-inputs.group class="w-full">
                                <x-inputs.select name="salesOrderOnline.delivery_address_id" label="Delivery Address"
                                    wire:model="salesOrderOnline.delivery_address_id">
                                    <option value="null" disabled>-- select --</option>
                                    @foreach ($deliveryAddressesForSelect as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </x-inputs.select>
                            </x-inputs.group>

                            <x-inputs.group class="w-full">
                                <x-inputs.text name="salesOrderOnline.receipt_no" label="Receipt No"
                                    wire:model="salesOrderOnline.receipt_no" maxlength="255"></x-inputs.text>
                            </x-inputs.group>

                            <x-inputs.group class="w-full">
                                <x-inputs.textarea name="salesOrderOnline.notes" label="Notes"
                                    wire:model="salesOrderOnline.notes" maxlength="255"></x-inputs.textarea>
                            </x-inputs.group>

                            <x-inputs.group class="w-full">
                                <div image-url="{{ $editing && $salesOrderOnline->image_sent ? \Storage::url($salesOrderOnline->image_sent) : '' }}"
                                    x-data="imageViewer()" @refresh.window="refreshUrl()">
                                    <x-inputs.partials.label name="salesOrderOnlineImageSent" label="Image Sent">
                                    </x-inputs.partials.label><br />

                                    <!-- Show the image -->
                                    <template x-if="imageUrl">
                                        <img :src="imageUrl" class="object-cover border border-gray-200 rounded "
                                            style="width: 100px; height: 100px;" />
                                    </template>

                                    <!-- Show the gray box when image is not available -->
                                    <template x-if="!imageUrl">
                                        <div class="bg-gray-100 border border-gray-200 rounded "
                                            style="width: 100px; height: 100px;"></div>
                                    </template>

                                    <div class="mt-2">
                                        <input type="file" name="salesOrderOnlineImageSent"
                                            id="salesOrderOnlineImageSent{{ $uploadIteration }}"
                                            wire:model="salesOrderOnlineImageSent" @change="fileChosen" />
                                    </div>

                                    @error('salesOrderOnlineImageSent')
                                        @include('components.inputs.partials.error')
                                    @enderror
                                </div>
                            </x-inputs.group>

                            <x-inputs.group class="w-full">
                                <x-inputs.select name="salesOrderOnline.status" label="Status"
                                    wire:model="salesOrderOnline.status">
                                    <option value="1" {{ $selected == '1' ? 'selected' : '' }}>belum dikirim
                                    </option>
                                    @role('super-admin|manager')
                                        <option value="2" {{ $selected == '2' ? 'selected' : '' }}>valid</option>
                                    @endrole
                                    <option value="3" {{ $selected == '3' ? 'selected' : '' }}>sudah dikirim
                                    </option>
                                    <option value="5" {{ $selected == '5' ? 'selected' : '' }}>siap dikirim
                                    </option>
                                    <option value="4" {{ $selected == '4' ? 'selected' : '' }}>perbaiki</option>
                                    <option value="6" {{ $selected == '6' ? 'selected' : '' }}>dikembalikan
                                    </option>
                                </x-inputs.select>
                            </x-inputs.group>
                        </div>

                        {{-- Sales Order Online Products --}}
                        <table class="min-w-full mt-4 border divide-y divide-gray-200">
                            <thead>
                                <th class="px-6 py-3 text-left bg-gray-50">
                                    <span
                                        class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase">Product</span>
                                </th>
                                <th class="px-6 py-3 text-left bg-gray-50">
                                    <span
                                        class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase">Quantity</span>
                                </th>
                                <th class="px-6 py-3 text-left bg-gray-50">
                                    <span
                                        class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase">Price</span>
                                </th>
                                <th class="w-56 px-6 py-3 text-left bg-gray-50"></th>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @forelse($salesOrderOnlineProducts as $index => $salesOrderOnlineProduct)
                                    <tr>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @if ($salesOrderOnlineProduct['is_saved'])
                                                <input type="hidden"
                                                    name="salesOrderOnlineProducts[{{ $index }}][product_id]"
                                                    wire:model="salesOrderOnlineProducts.{{ $index }}.product_id" />
                                                @if ($salesOrderOnlineProduct['product_name'])
                                                    {{ $salesOrderOnlineProduct['product_name'] }}
                                                @endif
                                            @else
                                                <select
                                                    name="salesOrderOnlineProducts[{{ $index }}][product_id]"
                                                    class="focus:outline-none w-full border {{ $errors->has('$salesOrderOnlineProducts.' . $index) ? 'border-red-500' : 'border-indigo-500' }} rounded-md p-1"
                                                    wire:model="salesOrderOnlineProducts.{{ $index }}.product_id">
                                                    <option value="">-- select --</option>
                                                    @foreach ($this->allProducts as $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('salesOrderOnlineProducts.' . $index)
                                                    <em class="text-sm text-red-500">
                                                        {{ $message }}
                                                    </em>
                                                @enderror
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @if ($salesOrderOnlineProduct['is_saved'])
                                                <input type="hidden"
                                                    name="salesOrderOnlineProducts[{{ $index }}][quantity]"
                                                    wire:model="salesOrderOnlineProducts.{{ $index }}.quantity" />
                                                {{ $salesOrderOnlineProduct['quantity'] }}
                                            @else
                                                <input type="number" step="1"
                                                    name="salesOrderOnlineProducts[{{ $index }}][quantity]"
                                                    class="w-full p-1 border border-indigo-500 rounded-md focus:outline-none"
                                                    wire:model="salesOrderOnlineProducts.{{ $index }}.quantity" />
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @if ($salesOrderOnlineProduct['is_saved'])
                                                <input type="hidden"
                                                    name="salesOrderOnlineProducts[{{ $index }}][price]"
                                                    wire:model="salesOrderOnlineProducts.{{ $index }}.price" />
                                                {{ $salesOrderOnlineProduct['price'] }}
                                            @else
                                                <input type="number" step="1"
                                                    name="salesOrderOnlineProducts[{{ $index }}][price]"
                                                    class="w-full p-1 border border-indigo-500 rounded-md focus:outline-none"
                                                    wire:model="salesOrderOnlineProducts.{{ $index }}.price" />
                                            @endif
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @if ($salesOrderOnlineProduct['is_saved'])
                                                <x-button wire:click.prevent="editProduct({{ $index }})">
                                                    Edit
                                                </x-button>
                                            @elseif($salesOrderOnlineProduct['product_id'])
                                                <x-button wire:click.prevent="saveProduct({{ $index }})">
                                                    Save
                                                </x-button>
                                            @endif
                                            <button
                                                class="px-4 py-2 ml-1 text-xs text-red-500 uppercase bg-red-200 border border-transparent rounded-md hover:text-red-700 hover:bg-red-300"
                                                wire:click.prevent="removeProduct({{ $index }})">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3"
                                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            Start adding products to order.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <x-button wire:click.prevent="addProduct">+ Add Product</x-button>
                        </div>
                        {{-- End Sales Order Online Products --}}

                        <div class="flex justify-end">
                            <table>
                                <tr class="text-left border-t border-gray-300">
                                    <th class="p-2">Totals</th>
                                    <td class="p-2">Rp {{ number_format($salesOrderOnline->totals) }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="mt-4">
                            <x-button type="submit">
                                Save
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
@endpush --}}
