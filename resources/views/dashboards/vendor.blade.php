<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Dashboard Vendor - McOrder</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-neutral-50 min-h-screen text-sm text-neutral-700">
    @php
        // fallback jika controller belum mengirim $orders
        $orders = $orders ?? collect();
    @endphp

    <!-- Header -->
    <header class="bg-white border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-4">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center relative">
                            @if(file_exists(public_path('images/mcorder-logo.png')))
                                <img src="{{ asset('images/mcorder-logo.png') }}" alt="McOrder" class="h-10 w-auto" />
                            @else
                                <div class="h-10 w-10"></div>
                            @endif

                            <div class="flex items-center ml-6 relative h-16">
                                <span class="text-red-600 font-semibold text-base">Dashboard</span>

                                <!-- red underline aligned with the bottom edge of the white header box -->
                                <span class="absolute left-0 bottom-0 w-28 h-1 bg-red-600 rounded-sm" style="transform: translateY(0);"></span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-4 relative">
                    <button id="user-menu-button" type="button" class="flex items-center gap-3 focus:outline-none" onclick="toggleUserMenu(event)">
                        <div class="text-right mr-2 max-w-xs">
                            <div class="font-medium text-neutral-900 truncate">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-neutral-500 truncate">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-red-600 text-white flex items-center justify-center font-semibold">
                            {{ strtoupper(substr(Auth::user()->name,0,1) ?? 'V') }}
                        </div>
                    </button>

                    <!-- Dropdown -->
                    <div id="user-menu" class="hidden absolute right-0 w-56 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50" style="top: calc(100% + 8px);">
                        <!-- header -->
                        <div class="px-4 py-3 border-b">
                            <div class="text-sm font-semibold text-neutral-900">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-neutral-500 mt-0.5">{{ ucfirst(Auth::user()->role) }}<span class="block text-xs text-neutral-400">{{ Auth::user()->store_name ?? '' }}</span></div>
                        </div>

                        <div class="py-1">
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
    </header>

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Title -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-neutral-900">Dashboard Vendor</h1>
            <p class="text-sm text-neutral-500">Kelola pesanan dan pengiriman - {{ Auth::user()->store_name ?? Auth::user()->name }}</p>
        </div>

        <!-- Stat Cards: equal-width responsive row without horizontal scroll -->
        <div class="mb-8">
            <div class="flex gap-4">
                <!-- card -->
                <div class="flex-1 min-w-0 bg-white rounded-xl p-5 h-44 flex flex-col justify-between transition-transform transform hover:-translate-y-1 hover:shadow-lg duration-200 ease-out">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-xs text-neutral-500">Total Pesanan</div>
                            <div class="text-3xl font-bold text-neutral-900">{{ $totalOrders ?? 0 }}</div>
                            <div class="text-xs text-neutral-400">Semua pesanan</div>
                        </div>
                        <div class="text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- card -->
                <div class="flex-1 min-w-0 bg-white rounded-xl p-5 h-44 flex flex-col justify-between transition-transform transform hover:-translate-y-1 hover:shadow-lg duration-200 ease-out">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-xs text-neutral-500">Pesanan Baru</div>
                            <div class="text-3xl font-bold text-blue-600">{{ $newOrders ?? 0 }}</div>
                            <div class="text-xs text-neutral-400">Perlu konfirmasi</div>
                        </div>
                        <div class="text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- card -->
                <div class="flex-1 min-w-0 bg-white rounded-xl p-5 h-44 flex flex-col justify-between transition-transform transform hover:-translate-y-1 hover:shadow-lg duration-200 ease-out">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-xs text-neutral-500">Dalam Proses</div>
                            <div class="text-3xl font-bold text-neutral-900">{{ $inProgress ?? 0 }}</div>
                            <div class="text-xs text-neutral-400">Sedang dikerjakan</div>
                        </div>
                        <div class="text-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 12h9M11 16h9M11 8h9M4 6h.01M4 10h.01M4 14h.01"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- card -->
                <div class="flex-1 min-w-0 bg-white rounded-xl p-5 h-44 flex flex-col justify-between transition-transform transform hover:-translate-y-1 hover:shadow-lg duration-200 ease-out">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-xs text-neutral-500">Selesai</div>
                            <div class="text-3xl font-bold text-neutral-900">{{ $completed ?? 0 }}</div>
                            <div class="text-xs text-neutral-400">Pesanan selesai</div>
                        </div>
                        <div class="text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- card -->
                <div class="flex-1 min-w-0 bg-white rounded-xl p-5 h-44 flex flex-col justify-between transition-transform transform hover:-translate-y-1 hover:shadow-lg duration-200 ease-out">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-xs text-neutral-500">Total Penjualan</div>
                            <div class="text-3xl font-bold text-red-600">Rp {{ number_format($totalSales ?? 0,0,',','.') }}</div>
                            <div class="text-xs text-neutral-400">Bulan ini</div>
                        </div>
                        <div class="text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Panel -->
        <div class="bg-white rounded-xl border shadow-sm p-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold">Daftar Pesanan</h3>
                    <p class="text-sm text-neutral-500">Kelola semua pesanan dari {{ Auth::user()->store_name ?? Auth::user()->name }}</p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input type="text" placeholder="Cari pesanan..." class="pl-10 pr-3 py-2 border rounded-md w-64 text-sm" />
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/></svg>
                        </div>
                    </div>

                    <select class="border rounded-md px-3 py-2 text-sm">
                        <option>Semua Status</option>
                    </select>
                </div>
            </div>

            <div class="overflow-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-neutral-500">
                        <tr>
                            <th class="py-3 px-4">No. Pesanan</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Toko</th>
                            <th class="py-3 px-4">Produk</th>
                            <th class="py-3 px-4">Qty</th>
                            <th class="py-3 px-4">Total Harga</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $o)
                            <tr class="border-t">
                                <td class="py-3 px-4">{{ $o->order_number ?? '-' }}</td>
                                <td class="py-3 px-4">{{ optional($o->created_at)->format('d/m/Y') }}</td>
                                <td class="py-3 px-4">{{ $o->store_name ?? $o->vendor_name ?? '-' }}</td>
                                <td class="py-3 px-4">{{ $o->product_name ?? '-' }}</td>
                                <td class="py-3 px-4">{{ $o->quantity ?? '-' }}</td>
                                <td class="py-3 px-4">Rp {{ number_format($o->total_price ?? 0,0,',','.') }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $s = strtolower($o->status ?? '');
                                        $badge = 'bg-gray-100 text-gray-700';
                                        if (str_contains($s,'new') || str_contains($s,'pesan')) $badge = 'bg-blue-100 text-blue-700';
                                        if (str_contains($s,'proses') || str_contains($s,'process')) $badge = 'bg-purple-100 text-purple-700';
                                        if (str_contains($s,'kirim') || str_contains($s,'deliv')) $badge = 'bg-orange-100 text-orange-700';
                                        if (str_contains($s,'selesai') || str_contains($s,'complete')) $badge = 'bg-green-100 text-green-700';
                                    @endphp
                                    <span class="inline-block px-3 py-1 rounded-full text-xs {{ $badge }}">{{ $o->status ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="#" class="inline-flex items-center justify-center w-9 h-9 border rounded-md text-neutral-600">👁</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-6 text-neutral-500">Belum ada pesanan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!-- footer removed per request (logo kept in header only) -->
    <script>
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
                // if click is outside menu and button
                const btn = document.getElementById('user-menu-button');
                if (btn && !btn.contains(ev.target) && !menu.contains(ev.target)) {
                    menu.classList.add('hidden');
                }
            }
        });
    </script>
</body>
</html>
