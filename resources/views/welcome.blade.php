<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PT Asa Pangan Bangsa </title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="antialiased">
    <div x-data="{ isOpen: false }" class="bg-white dark:bg-gray-900">
        <!--
            Mobile menu

            Off-canvas menu for mobile, show/hide based on off-canvas menu state.
        -->
        <div x-show="isOpen" class="relative z-40 lg:hidden" role="dialog" aria-modal="true">
            <!--
                Off-canvas menu backdrop, show/hide based on off-canvas menu state.

                Entering: "transition-opacity ease-linear duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                Leaving: "transition-opacity ease-linear duration-300"
                    From: "opacity-100"
                    To: "opacity-0"
            -->
            <div x-show="isOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-25"></div>

            <div x-show="isOpen" class="fixed inset-0 z-40 flex">
                <!--
                    Off-canvas menu, show/hide based on off-canvas menu state.

                    Entering: "transition ease-in-out duration-300 transform"
                    From: "-translate-x-full"
                    To: "translate-x-0"
                    Leaving: "transition ease-in-out duration-300 transform"
                    From: "translate-x-0"
                    To: "-translate-x-full"
                -->
                <div x-show="isOpen" x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                    class="relative flex flex-col w-full max-w-xs pb-12 overflow-y-auto bg-white shadow-xl">
                    <div class="flex px-4 pt-5 pb-2">
                        <button @click="isOpen = !isOpen" type="button"
                            class="inline-flex items-center justify-center p-2 -m-2 text-gray-400 rounded-md">
                            <span class="sr-only">Close menu</span>
                            <!-- Heroicon name: outline/x-mark -->
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Links -->
                    <div class="px-4 py-6 space-y-6 border-t border-gray-200">
                        <div class="flow-root">
                            <a href="#" class="block p-2 -m-2 font-medium text-gray-900">Company</a>
                        </div>

                        <div class="flow-root">
                            <a href="#" class="block p-2 -m-2 font-medium text-gray-900">Stores</a>
                        </div>
                    </div>

                    <div class="px-4 py-6 space-y-6 border-t border-gray-200">
                        @if (Route::has('login'))
                            @auth
                                @role('super-admin|supervisor|manager|staff')
                                    <div class="flow-root">
                                        <a href="{{ url('/dashboard') }}"
                                            class="block p-2 -m-2 font-medium text-gray-900">Dashboard</a>
                                    </div>
                                @endrole
                            @else
                                @if (Route::has('register'))
                                    <div class="flow-root">
                                        <a href="{{ route('register') }}"
                                            class="block p-2 -m-2 font-medium text-gray-900">Create an
                                            account</a>
                                    </div>
                                @endif
                                <div class="flow-root">
                                    <a href="{{ route('login') }}" class="block p-2 -m-2 font-medium text-gray-900">Sign
                                        in</a>
                                </div>
                            @endauth
                        @endif
                    </div>

                    <div class="px-4 py-6 space-y-6 border-t border-gray-200">
                        <!-- Currency selector -->
                        <form>
                            <div class="inline-block">
                                <label for="mobile-currency" class="sr-only">Currency</label>
                                <div
                                    class="relative -ml-2 border-transparent rounded-md group focus-within:ring-2 focus-within:ring-white">
                                    {{-- <select id="mobile-currency" name="currency"
                                        class="flex items-center rounded-md border-transparent bg-none py-0.5 pl-2 pr-5 text-sm font-medium text-gray-700 focus:border-transparent focus:outline-none focus:ring-0 group-hover:text-gray-800">
                                        <option>CAD</option>

                                        <option>USD</option>

                                        <option>AUD</option>

                                        <option>EUR</option>

                                        <option>GBP</option>
                                    </select> --}}
                                    <div class="absolute inset-y-0 right-0 flex items-center pointer-events-none">
                                        <!-- Heroicon name: mini/chevron-down -->
                                        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero section -->
        <div class="relative bg-gray-900">
            <!-- Decorative image and overlay -->
            <div aria-hidden="true" class="absolute inset-0 overflow-hidden">
                <img src="https://tailwindui.com/img/ecommerce-images/home-page-01-hero-full-width.jpg" alt=""
                    class="object-cover object-center w-full h-full">
            </div>
            <div aria-hidden="true" class="absolute inset-0 bg-gray-900 opacity-50"></div>

            <!-- Navigation -->
            <header class="relative z-10">
                <nav aria-label="Top">
                    <!-- Top navigation -->
                    <div class="bg-gray-900">
                        <div class="flex items-center justify-between h-10 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                            <!-- Currency selector -->
                            <form>
                                <div>
                                    <label for="desktop-currency" class="sr-only">Currency</label>
                                    <div
                                        class="relative -ml-2 bg-gray-900 border-transparent rounded-md group focus-within:ring-2 focus-within:ring-white">
                                        {{-- <select id="desktop-currency" name="currency"
                                            class="flex items-center rounded-md border-transparent bg-gray-900 bg-none py-0.5 pl-2 pr-5 text-sm font-medium text-white focus:border-transparent focus:outline-none focus:ring-0 group-hover:text-gray-100">
                                            <option>CAD</option>

                                            <option>USD</option>

                                            <option>AUD</option>

                                            <option>EUR</option>

                                            <option>GBP</option>
                                        </select> --}}
                                        {{-- <div class="absolute inset-y-0 right-0 flex items-center pointer-events-none">
                                            <!-- Heroicon name: mini/chevron-down -->
                                            <svg class="w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div> --}}
                                    </div>
                                </div>
                            </form>

                            <div class="flex items-center space-x-6">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/dashboard') }}"
                                            class="text-sm font-medium text-white hover:text-gray-100">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="text-sm font-medium text-white hover:text-gray-100">Sign
                                            in</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}"
                                                class="text-sm font-medium text-white hover:text-gray-100">Create an
                                                account</a>
                                        @endif
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Secondary navigation -->
                    <div class="bg-white bg-opacity-10 backdrop-blur-md backdrop-filter">
                        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                            <div>
                                <div class="flex items-center justify-between h-16">
                                    <!-- Logo (lg+) -->
                                    <div class="hidden lg:flex lg:flex-1 lg:items-center">
                                        <a href="#">
                                            <span class="sr-only">Your Company</span>
                                            <img class="w-auto h-8"
                                                src="https://tailwindui.com/img/logos/mark.svg?color=white"
                                                alt="">
                                        </a>
                                    </div>

                                    <div class="hidden h-full lg:flex">
                                        <!-- Flyout menus -->
                                        <div class="inset-x-0 bottom-0 px-4">
                                            <div class="flex justify-center h-full space-x-8">
                                                <a href="#"
                                                    class="flex items-center text-sm font-medium text-white">Company</a>

                                                <a href="#"
                                                    class="flex items-center text-sm font-medium text-white">Stores</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mobile menu and search (lg-) -->
                                    <div class="flex items-center flex-1 lg:hidden">
                                        <!-- Mobile menu toggle, controls the 'mobileMenuOpen' state. -->
                                        <button type="button" class="p-2 -ml-2 text-white">
                                            <span class="sr-only">Open menu</span>
                                            <!-- Heroicon name: outline/bars-3 -->
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                            </svg>
                                        </button>

                                        <!-- Search -->
                                        <a href="#" class="p-2 ml-2 text-white">
                                            <span class="sr-only">Search</span>
                                            <!-- Heroicon name: outline/magnifying-glass -->
                                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                            </svg>
                                        </a>
                                    </div>

                                    <!-- Logo (lg-) -->
                                    <a href="#" class="lg:hidden">
                                        <span class="sr-only">Your Company</span>
                                        <img src="https://tailwindui.com/img/logos/mark.svg?color=white"
                                            alt="" class="w-auto h-8">
                                    </a>

                                    <div class="flex items-center justify-end flex-1">
                                        <a href="#"
                                            class="hidden text-sm font-medium text-white lg:block">Search</a>

                                        <div class="flex items-center lg:ml-8">
                                            <!-- Help -->
                                            <a href="#" class="p-2 text-white lg:hidden">
                                                <span class="sr-only">Help</span>
                                                <!-- Heroicon name: outline/question-mark-circle -->
                                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                                </svg>
                                            </a>
                                            <a href="#"
                                                class="hidden text-sm font-medium text-white lg:block">Help</a>

                                            <!-- Cart -->
                                            @livewire('e-products.cart-counter')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            {{-- <div class="relative flex flex-col items-center max-w-3xl px-6 py-32 mx-auto text-center sm:py-64 lg:px-0">
                <h1 class="text-4xl font-bold tracking-tight text-white lg:text-6xl">New arrivals are here</h1>
                <p class="mt-4 text-xl text-white">The new arrivals have, well, newly arrived. Check out the latest
                    options from our summer small-batch release while they're still in stock.</p>
                <a href="#"
                    class="inline-block px-8 py-3 mt-8 text-base font-medium text-gray-900 bg-white border border-transparent rounded-md hover:bg-gray-100">Shop
                    New Arrivals</a>
            </div> --}}
        </div>

        <main>
            <!-- Product section -->
            {{-- <livewire:e-products.e-products-list /> --}}
            @livewire('e-products.e-products-list')

        </main>

        @include('layouts.footer-welcome')
    </div>

    @livewireScripts
</body>

</html>
