<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - McOrder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-neutral-200 flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-neutral-200">
                @php
                    $logoPaths = [
                        'images/Logo MCorder.png',
                        'images/Logo MCorder.jpg',
                        'images/logo-mcorder.png',
                        'images/logo-mcorder.jpg',
                    ];
                    $logoFound = false;
                    foreach ($logoPaths as $path) {
                        if (file_exists(public_path($path))) {
                            $logoFound = $path;
                            break;
                        }
                    }
                @endphp
                @if($logoFound)
                    <img src="{{ asset($logoFound) }}" alt="McOrder" class="h-10 w-auto">
                @else
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-yellow-400 text-red-600 font-bold text-lg">M</span>
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-neutral-900">McOrder</span>
                            <span class="text-xs text-neutral-500">McDonald's Citra Garden</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-red-50 text-red-600 font-semibold mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-neutral-200">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-neutral-900 truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-neutral-500">{{ Auth::user()->store_name }}</div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-neutral-600 hover:bg-neutral-100 rounded-lg transition">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white border-b border-neutral-200 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-neutral-900">Dashboard</h1>
                        <p class="text-sm text-neutral-600 mt-1">Kelola dan pantau pesanan bahan baku non-HAVI</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <button class="p-2 hover:bg-neutral-100 rounded-lg transition">
                            <svg class="w-6 h-6 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </button>
                        <div class="flex items-center gap-2">
                            <div class="text-right">
                                <div class="text-sm font-semibold text-neutral-900">{{ Auth::user()->role === 'manager_stock' ? 'Manager Stock' : ucfirst(Auth::user()->role) }}</div>
                                <div class="text-xs text-neutral-500">{{ Auth::user()->store_name }}</div>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-8">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">✅</span>
                            <p class="text-green-800 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Statistik Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Pesanan -->
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <p class="text-sm text-neutral-600 font-medium">Total Pesanan</p>
                                <p class="text-xs text-neutral-500 mt-1">Semua pesanan</p>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-neutral-900">{{ $totalOrders }}</p>
                    </div>

                    <!-- Menunggu Konfirmasi -->
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <p class="text-sm text-neutral-600 font-medium">Menunggu Konfirmasi</p>
                                <p class="text-xs text-neutral-500 mt-1">Perlu disetujui</p>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-neutral-900">{{ $pendingOrders }}</p>
                    </div>

                    <!-- Sedang Diproses -->
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <p class="text-sm text-neutral-600 font-medium">Sedang Diproses</p>
                                <p class="text-xs text-neutral-500 mt-1">Dalam pengiriman</p>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-neutral-900">{{ $inProgressOrders }}</p>
                    </div>

                    <!-- Selesai -->
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <p class="text-sm text-neutral-600 font-medium">Selesai</p>
                                <p class="text-xs text-neutral-500 mt-1">Pesanan selesai</p>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-neutral-900">{{ $completedOrders }}</p>
                    </div>
                </div>

                <!-- Daftar Pesanan -->
                <div class="bg-white rounded-xl shadow-sm border border-neutral-200">
                    <!-- Header -->
                    <div class="p-6 border-b border-neutral-200">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-lg font-bold text-neutral-900">Daftar Pesanan</h2>
                                <p class="text-sm text-neutral-600 mt-1">Kelola semua pesanan bahan baku dari berbagai vendor</p>
                            </div>
                            <button class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Buat Pesanan Baru
                            </button>
                        </div>

                        <!-- Search & Filter -->
                        <div class="flex items-center gap-4">
                            <div class="flex-1 relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input type="text" placeholder="Cari pesanan..." class="w-full pl-10 pr-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            </div>
                            <select class="px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <option value="">Semua Status</option>
                                <option value="pending">Menunggu Konfirmasi</option>
                                <option value="confirmed">Dikonfirmasi</option>
                                <option value="in_progress">Sedang Diproses</option>
                                <option value="completed">Selesai</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-neutral-50 border-b border-neutral-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">No. Pesanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Vendor</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Total Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Est. Kirim</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-neutral-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">{{ $order->order_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">{{ $order->vendor_name }}</td>
                                        <td class="px-6 py-4 text-sm text-neutral-900">{{ $order->product_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">{{ $order->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->getStatusBadgeColor() }}">
                                                {{ $order->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">
                                            {{ $order->estimated_delivery ? $order->estimated_delivery->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center gap-2">
                                                <button class="p-1 hover:bg-neutral-100 rounded transition" title="Lihat Detail">
                                                    <svg class="w-5 h-5 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </button>
                                                <button class="p-1 hover:bg-neutral-100 rounded transition" title="Download">
                                                    <svg class="w-5 h-5 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-12 text-center text-neutral-500">
                                            <svg class="w-12 h-12 mx-auto mb-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                            <p class="text-sm font-medium">Belum ada pesanan</p>
                                            <p class="text-xs mt-1">Klik tombol "Buat Pesanan Baru" untuk membuat pesanan pertama</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
