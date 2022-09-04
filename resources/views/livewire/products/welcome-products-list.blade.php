<div>


    <section aria-labelledby="collection-heading" class="max-w-xl px-4 pt-6 mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
        <div class="px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8 xl:px-0">
            <h2 id="category-heading" class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Produk Unggulan
            </h2>
            {{-- <a href="#"
                        class="hidden text-sm font-semibold text-indigo-600 hover:text-indigo-500 sm:block">
                        Browse all categories
                        <span aria-hidden="true"> &rarr;</span>
                    </a> --}}
        </div>

        <div class="grid grid-cols-1 mt-8 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
            @foreach ($eProducts as $eProduct)
                <div>
                    <div class="relative">
                        <div class="relative w-full overflow-hidden rounded-lg h-72">
                            <a href="{{ \Storage::url($eProduct->image) }}">
                                <img src="{{ $eProduct->image ? \Storage::url($eProduct->image) : '' }}"
                                    alt="Front of zip tote bag with white canvas, black canvas straps and handle, and black zipper pulls."
                                    class="object-cover object-center w-full h-full">
                            </a>
                        </div>
                        <div class="relative mt-4">
                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $eProduct->product->name }}</h3>

                            <p class="mt-1 text-sm text-gray-500">{{ $eProduct->product->description }}</p>
                        </div>
                        <div
                            class="absolute inset-x-0 top-0 flex items-end justify-end p-4 overflow-hidden rounded-lg h-72">
                            <div aria-hidden="true"
                                class="absolute inset-x-0 bottom-0 opacity-50 h-36 bg-gradient-to-t from-black">
                            </div>
                            <p class="relative text-lg font-semibold text-white">@currency($eProduct->price)</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="#"
                            class="relative flex items-center justify-center px-8 py-2 text-sm font-medium text-gray-900 bg-gray-100 border border-transparent rounded-md hover:bg-gray-200">Add
                            to bag<span class="sr-only">, Zip Tote Basket</span></a>
                    </div>
                </div>
            @endforeach
        </div>


        {{-- <div class="px-4 mt-6 sm:hidden">
                    <a href="#" class="block text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                        Browse all categories
                        <span aria-hidden="true"> &rarr;</span>
                    </a>
                </div> --}}
    </section>
</div>
