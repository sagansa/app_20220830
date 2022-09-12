 <div class="bg-white">
     <div class="pt-6 pb-16 sm:pb-24">
         <nav aria-label="Breadcrumb" class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
             <ol role="list" class="flex items-center space-x-4">

                 <li>
                     <div class="flex items-center">
                         <a href="#"
                             class="mr-4 text-sm font-medium text-gray-900">{{ $eProduct->onlineCategory->name }}</a>
                         <svg viewBox="0 0 6 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                             class="w-auto h-5 text-gray-300">
                             <path d="M4.878 4.34H3.551L.27 16.532h1.327l3.281-12.19z" fill="currentColor" />
                         </svg>
                     </div>
                 </li>

                 <li class="text-sm">
                     <a href="#" aria-current="page"
                         class="font-medium text-gray-500 hover:text-gray-600">{{ $eProduct->product->name }}</a>
                 </li>
             </ol>
         </nav>
         <div class="max-w-2xl px-4 mx-auto mt-8 sm:px-6 lg:max-w-7xl lg:px-8">
             <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
                 <div class="lg:col-span-5 lg:col-start-8">
                     <div class="flex justify-between">
                         <h1 class="text-xl font-medium text-gray-900">{{ $eProduct->product->name }} -
                             {{ $eProduct->product->unit->unit }}</h1>
                         <p class="text-xl font-medium text-gray-900">@currency($eProduct->price)</p>
                     </div>

                 </div>

                 <!-- Image gallery -->
                 <div class="mt-8 lg:col-span-7 lg:col-start-1 lg:row-span-3 lg:row-start-1 lg:mt-0">
                     <h2 class="sr-only">Images</h2>

                     <div class="grid grid-cols-1 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8">
                         <img src="{{ \Storage::url($eProduct->image) }}" alt=""
                             class="rounded-lg lg:col-span-2 lg:row-span-2">
                     </div>
                 </div>

                 <div class="mt-2 lg:col-span-5">
                     <form>

                         <div class="flex justify-between">
                             <label for="first-name"
                                 class="block mt-2 text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Quantity</label>
                             <div class="mt-1 sm:col-span-2 sm:mt-0">
                                 <input type="number" name="first-name" id="first-name" autocomplete="given-name"
                                     class="block w-full max-w-lg text-right border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm">

                             </div>
                         </div>

                         <div class="flex justify-between">
                             <label for="first-name"
                                 class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Subtotal</label>
                             <div class="pt-1 sm:col-span-2 sm:mt-0">
                                 <p>@currency($eProduct->price)</p>

                             </div>
                         </div>
                         <button type="submit"
                             class="flex items-center justify-center w-full px-8 py-3 mt-8 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add
                             to cart</button>
                     </form>

                     <!-- Product details -->
                     <div class="mt-10">
                         <h2 class="text-sm font-medium text-gray-900">Description</h2>

                         <div class="mt-4 prose-sm prose text-gray-500">
                             <p>{{ $eProduct->product->description }}</p>
                         </div>
                     </div>

                     <div class="pt-8 mt-8 border-t border-gray-200">
                         <h2 class="text-sm font-medium text-gray-900">Fabric &amp; Care</h2>

                         <div class="mt-4 prose-sm prose text-gray-500">
                             <ul role="list">
                                 <li>Only the best materials</li>

                                 <li>Ethically and locally made</li>

                                 <li>Pre-washed and pre-shrunk</li>

                                 <li>Machine wash cold with similar colors</li>
                             </ul>
                         </div>
                     </div>


                 </div>
             </div>
         </div>
     </div>
 </div>
