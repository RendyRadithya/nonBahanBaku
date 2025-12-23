<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'McOrder') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/Logo MCorder.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/Logo MCorder.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-neutral-50 min-h-screen text-sm text-neutral-700 font-sans antialiased">
        <div class="min-h-screen">
            <!-- Header Navigation -->
            <header class="bg-white border-b border-neutral-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <!-- Logo & Dashboard -->
                        <div class="flex items-center gap-4">
                            <div class="flex items-center">
                                <a href="{{ route('dashboard') }}" class="flex items-center">
                                    <img src="{{ asset('images/Logo MCorder.png') }}" alt="McOrder" class="h-10 w-auto" />
                                </a>

                                <!-- Navigation Menu (desktop) -->
                                <nav class="hidden md:flex items-center ml-6 h-16 gap-1">
                                    <a href="{{ route('dashboard') }}" class="relative h-16 flex items-center px-4 {{ request()->routeIs('dashboard') ? 'text-red-600 font-semibold' : 'text-neutral-600 hover:text-neutral-900' }} transition">
                                        <span>Dashboard</span>
                                        @if(request()->routeIs('dashboard'))
                                            <span class="absolute left-0 bottom-0 w-full h-1 bg-red-600 rounded-t-sm"></span>
                                        @endif
                                    </a>
                                    @if(Auth::user()->role === 'manager_stock')
                                    <a href="{{ route('catalog') }}" class="relative h-16 flex items-center px-4 {{ request()->routeIs('catalog') ? 'text-red-600 font-semibold' : 'text-neutral-600 hover:text-neutral-900' }} transition">
                                        <span>Katalog Produk</span>
                                        @if(request()->routeIs('catalog'))
                                            <span class="absolute left-0 bottom-0 w-full h-1 bg-red-600 rounded-t-sm"></span>
                                        @endif
                                    </a>
                                    <a href="{{ route('reports') }}" class="relative h-16 flex items-center px-4 {{ request()->routeIs('reports') ? 'text-red-600 font-semibold' : 'text-neutral-600 hover:text-neutral-900' }} transition">
                                        <span>Laporan</span>
                                        @if(request()->routeIs('reports'))
                                            <span class="absolute left-0 bottom-0 w-full h-1 bg-red-600 rounded-t-sm"></span>
                                        @endif
                                    </a>
                                    <a href="{{ route('order.history') }}" class="relative h-16 flex items-center px-4 {{ request()->routeIs('order.history') ? 'text-red-600 font-semibold' : 'text-neutral-600 hover:text-neutral-900' }} transition">
                                        <span>Riwayat Pesanan</span>
                                        @if(request()->routeIs('order.history'))
                                            <span class="absolute left-0 bottom-0 w-full h-1 bg-red-600 rounded-t-sm"></span>
                                        @endif
                                    </a>
                                    @endif
                                    @if(Auth::user()->role === 'vendor')
                                    <a href="{{ route('vendor.reports') }}" class="relative h-16 flex items-center px-4 {{ request()->routeIs('vendor.reports') ? 'text-red-600 font-semibold' : 'text-neutral-600 hover:text-neutral-900' }} transition">
                                        <span>Laporan Penjualan</span>
                                        @if(request()->routeIs('vendor.reports'))
                                            <span class="absolute left-0 bottom-0 w-full h-1 bg-red-600 rounded-t-sm"></span>
                                        @endif
                                    </a>
                                    <a href="{{ route('vendor.history') }}" class="relative h-16 flex items-center px-4 {{ request()->routeIs('vendor.history') ? 'text-red-600 font-semibold' : 'text-neutral-600 hover:text-neutral-900' }} transition">
                                        <span>Riwayat Pesanan</span>
                                        @if(request()->routeIs('vendor.history'))
                                            <span class="absolute left-0 bottom-0 w-full h-1 bg-red-600 rounded-t-sm"></span>
                                        @endif
                                    </a>
                                    @endif
                                </nav>

                                <!-- Mobile menu button -->
                                <div class="md:hidden ml-3">
                                    <button id="mobile-menu-button" aria-expanded="false" aria-controls="mobile-menu" class="p-2 rounded-md hover:bg-neutral-100 focus:outline-none" onclick="toggleMobileMenu()">
                                        <svg class="h-6 w-6 text-neutral-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- User Menu & Notifications -->
                        <div class="flex items-center gap-4">
                            @include('components.notifications')

                            <div class="relative">
                                <button id="user-menu-button" type="button" class="flex items-center gap-3 focus:outline-none" onclick="toggleUserMenu(event)">
                                <div class="text-right mr-2 max-w-xs hidden sm:block">
                                    <div class="font-medium text-neutral-900 truncate">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-neutral-500 truncate">{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</div>
                                </div>
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="h-10 w-10 rounded-full object-cover border-2 border-gray-200">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-red-600 text-white flex items-center justify-center font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="user-menu" class="hidden absolute right-0 w-56 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50" style="top: calc(100% + 8px);">
                                <!-- Header -->
                                <div class="px-4 py-3 border-b">
                                    <div class="text-sm font-semibold text-neutral-900">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-neutral-500 mt-0.5">
                                        {{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}
                                        @if(Auth::user()->store_name)
                                            <span class="block text-xs text-neutral-400">{{ Auth::user()->store_name }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>Profile</span>
                                    </a>

                                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-neutral-100" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                                        </svg>
                                        <span class="font-medium">Logout</span>
                                    </a>

                                    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mobile navigation (hidden by default) -->
                <div id="mobile-menu" class="md:hidden hidden border-t border-neutral-100">
                    <div class="px-4 py-3 space-y-1">
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('dashboard') ? 'text-red-600 font-semibold bg-neutral-50' : 'text-neutral-700 hover:bg-neutral-50' }}">Dashboard</a>
                        @if(Auth::user()->role === 'manager_stock')
                            <a href="{{ route('catalog') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('catalog') ? 'text-red-600 font-semibold bg-neutral-50' : 'text-neutral-700 hover:bg-neutral-50' }}">Katalog Produk</a>
                            <a href="{{ route('reports') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('reports') ? 'text-red-600 font-semibold bg-neutral-50' : 'text-neutral-700 hover:bg-neutral-50' }}">Laporan</a>
                            <a href="{{ route('order.history') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('order.history') ? 'text-red-600 font-semibold bg-neutral-50' : 'text-neutral-700 hover:bg-neutral-50' }}">Riwayat Pesanan</a>
                        @endif
                        @if(Auth::user()->role === 'vendor')
                            <a href="{{ route('vendor.reports') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('vendor.reports') ? 'text-red-600 font-semibold bg-neutral-50' : 'text-neutral-700 hover:bg-neutral-50' }}">Laporan Penjualan</a>
                            <a href="{{ route('vendor.history') }}" class="block px-3 py-2 rounded-md {{ request()->routeIs('vendor.history') ? 'text-red-600 font-semibold bg-neutral-50' : 'text-neutral-700 hover:bg-neutral-50' }}">Riwayat Pesanan</a>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Page Heading (Optional) -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
        </div>

        <!-- User Menu Toggle Script -->
        <script>
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                const btn = document.getElementById('mobile-menu-button');
                if (!menu) return;
                const isHidden = menu.classList.contains('hidden');
                if (isHidden) {
                    menu.classList.remove('hidden');
                    if (btn) btn.setAttribute('aria-expanded', 'true');
                } else {
                    menu.classList.add('hidden');
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                }
            }

            function toggleUserMenu(e) {
                e.stopPropagation();
                const menu = document.getElementById('user-menu');
                if (!menu) return;
                menu.classList.toggle('hidden');
            }

            // Close menu when clicking outside
            document.addEventListener('click', function (ev) {
                const menu = document.getElementById('user-menu');
                if (!menu) return;
                if (!menu.classList.contains('hidden')) {
                    const btn = document.getElementById('user-menu-button');
                    if (btn && !btn.contains(ev.target) && !menu.contains(ev.target)) {
                        menu.classList.add('hidden');
                    }
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>
