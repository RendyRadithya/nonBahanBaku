<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-6">
        <!-- Page Header -->
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900">Dashboard</h1>
                <p class="text-sm text-neutral-600 mt-1">Kelola dan pantau pesanan bahan baku non-HAVI</p>
            </div>

            <button id="open-create-order" class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Pesanan Baru
            </button>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Total Pesanan -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Total Pesanan</div>
                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-neutral-900">{{ $totalOrders ?? 0 }}</div>
                <div class="text-xs text-neutral-500 mt-1">Semua pesanan</div>
            </div>

            <!-- Menunggu Konfirmasi -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Menunggu Konfirmasi</div>
                    <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-neutral-900">{{ $pendingOrders ?? 0 }}</div>
                <div class="text-xs text-neutral-500 mt-1">Perlu ditindaklanjuti</div>
            </div>

            <!-- Sedang Diproses -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Sedang Diproses</div>
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-neutral-900">{{ $inProgressOrders ?? 0 }}</div>
                <div class="text-xs text-neutral-500 mt-1">Dalam pengiriman</div>
            </div>

            <!-- Selesai -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Selesai</div>
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-neutral-900">{{ $completedOrders ?? 0 }}</div>
                <div class="text-xs text-neutral-500 mt-1">Pesanan selesai</div>
            </div>
        </div>

        <!-- Daftar Pesanan -->
        <div class="bg-white rounded-xl shadow-sm border border-neutral-200">
            <!-- Header -->
            <div class="p-6 border-b border-neutral-200">
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-neutral-900">Daftar Pesanan</h2>
                    <p class="text-sm text-neutral-600 mt-1">Kelola semua pesanan bahan baku dari berbagai vendor</p>
                </div>

                <!-- Search & Filter -->
                <div class="flex items-center gap-4">
                    <form id="manager-filters" method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-4 w-full">
                        <div class="flex-1 relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" id="search-input" name="q" value="{{ request('q') }}" placeholder="Cari pesanan..." class="w-full pl-10 pr-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>
                        <select id="status-filter" name="status" class="px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="" {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>Semua Status</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </form>
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
                                        <button class="p-1 hover:bg-neutral-100 rounded transition btn-tracking" title="Lihat Tracking" data-id="{{ $order->id }}">
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


    <!-- Tracking Modal -->
    <div id="tracking-modal" class="fixed inset-0 hidden items-center justify-center z-50" style="background-color: rgba(0,0,0,0.5);">
        <div class="bg-neutral-50 rounded-xl shadow-2xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="bg-white px-6 py-4 border-b border-neutral-200 flex items-center justify-between sticky top-0 z-10">
                <div>
                    <h3 class="text-lg font-bold text-neutral-900">Tracking Pesanan</h3>
                    <div id="tracking-sub" class="text-sm text-neutral-500 mt-0.5">ORD-xxxx - Status</div>
                </div>
                <button id="close-tracking" class="text-neutral-400 hover:text-neutral-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-6 space-y-5">
                <!-- Informasi Pesanan -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-neutral-100">
                    <h4 class="font-semibold text-neutral-900 mb-4 text-sm">Informasi Pesanan</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-neutral-600">No. Pesanan</span>
                            <span class="font-semibold text-neutral-900" id="ti-order-number">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-600">Tanggal Pesan</span>
                            <span class="text-neutral-900" id="ti-order-date">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-600">Produk</span>
                            <span class="text-neutral-900 font-medium" id="ti-product">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-600">Jumlah</span>
                            <span class="text-neutral-900" id="ti-qty">-</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-neutral-100">
                            <span class="text-neutral-600 font-medium">Total Harga</span>
                            <span class="font-bold text-red-600" id="ti-total">-</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Pengiriman -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-neutral-100">
                    <h4 class="font-semibold text-neutral-900 mb-5 text-sm">Timeline Pengiriman</h4>
                    <div id="ti-timeline" class="space-y-4">
                        <!-- Timeline items will be inserted here -->
                    </div>
                </div>

                <!-- Informasi Vendor -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-neutral-100">
                    <h4 class="font-semibold text-neutral-900 mb-4 text-sm">Informasi Vendor</h4>
                    <div class="flex items-start gap-3 mb-4">
                        <div id="ti-vendor-avatar" class="w-12 h-12 rounded-full bg-red-600 text-white flex items-center justify-center font-bold text-lg flex-shrink-0">V</div>
                        <div class="flex-1">
                            <div id="ti-vendor-name" class="font-semibold text-neutral-900">-</div>
                            <div class="text-xs text-neutral-500 mt-0.5">Vendor Terpercaya</div>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-neutral-600">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span id="ti-vendor-phone">-</span>
                        </div>
                        <div class="flex items-center gap-2 text-neutral-600">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span id="ti-vendor-email" class="break-all">-</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-neutral-100">
                        <label class="block text-xs text-neutral-500 mb-2">No. Resi Pengiriman</label>
                        <div id="ti-resi" class="bg-neutral-50 border border-neutral-200 px-3 py-2 rounded-lg text-sm font-mono text-neutral-700">-</div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button id="tracking-close" class="px-5 py-2.5 rounded-lg border border-neutral-300 text-neutral-700 font-medium hover:bg-neutral-50 transition">Tutup</button>
                    <button id="tracking-confirm" class="px-5 py-2.5 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition shadow-sm">Konfirmasi Terima</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Order Modal -->
    <div id="create-order-modal" class="fixed inset-0 hidden items-center justify-center z-50" style="background-color: rgba(0,0,0,0.5);">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-5 border-b border-neutral-100 flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-bold text-neutral-900">Buat Pesanan Baru</h3>
                    <p class="text-sm text-neutral-500 mt-1">Isi form di bawah untuk membuat pesanan bahan baku baru</p>
                </div>
                <button id="close-create-order" class="text-neutral-400 hover:text-neutral-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-6 font-sans text-sm">
                <div class="mb-5">
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Pilih Vendor</label>
                    <div class="relative">
                        <button id="vendor-btn" type="button" class="w-full text-left px-4 py-3 rounded-lg bg-neutral-50 border-transparent focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition flex items-center justify-between group">
                            <span id="vendor-btn-label" class="text-neutral-500">Pilih vendor...</span>
                            <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-600 transition" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.12 1.02l-4.25 4.66a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd"/></svg>
                        </button>
                        <div id="vendor-list" class="hidden absolute left-0 right-0 mt-2 bg-white border border-neutral-100 rounded-lg shadow-lg max-h-56 overflow-auto z-40">
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Produk</label>
                    <div class="relative">
                        <button id="product-btn" type="button" class="w-full text-left px-4 py-3 rounded-lg bg-neutral-50 border-transparent focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition flex items-center justify-between disabled:opacity-60 disabled:cursor-not-allowed group" disabled>
                            <span id="product-btn-label" class="text-neutral-500">Pilih produk...</span>
                            <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-600 transition" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.12 1.02l-4.25 4.66a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd"/></svg>
                        </button>
                        <div id="product-list" class="hidden absolute left-0 right-0 mt-2 bg-white border border-neutral-100 rounded-lg shadow-lg max-h-56 overflow-auto z-40">
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Jumlah</label>
                    <input id="quantity-input" type="number" min="1" placeholder="Masukkan jumlah..." class="w-full px-4 py-3 rounded-lg bg-neutral-50 border-transparent focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition placeholder-neutral-400" />
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-neutral-700 mb-2">Tanggal Pengiriman Diharapkan</label>
                    <input id="date-input" type="date" class="w-full px-4 py-3 rounded-lg bg-neutral-50 border-transparent focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition text-neutral-500" />
                </div>

                <div id="order-summary" class="mb-6 border border-red-100 rounded-lg p-4 bg-red-50 hidden">
                    <h4 class="text-sm font-bold text-red-800 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Ringkasan Pesanan
                    </h4>
                    <div class="space-y-2 text-sm text-neutral-700">
                        <div class="flex justify-between"><span>Produk</span> <span class="font-medium" id="summary-product">-</span></div>
                        <div class="flex justify-between"><span>Harga Satuan</span> <span class="font-medium" id="summary-price">-</span></div>
                        <div class="flex justify-between"><span>Jumlah</span> <span class="font-medium" id="summary-qty">-</span></div>
                        <div class="flex justify-between"><span>Biaya Kirim (Est.)</span> <span class="font-medium" id="summary-shipping">-</span></div>
                        <div class="border-t border-red-200 pt-2 mt-2 flex justify-between items-center">
                            <span class="font-semibold text-red-900">Total Estimasi</span>
                            <span class="font-bold text-lg text-red-600" id="summary-total">-</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button id="cancel-create" class="px-6 py-2.5 rounded-lg border border-neutral-200 text-neutral-600 font-medium hover:bg-neutral-50 transition">Batal</button>
                    <button id="submit-create" class="px-6 py-2.5 rounded-lg bg-red-400 text-white font-medium hover:bg-red-500 shadow-sm hover:shadow transition">Buat Pesanan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div id="order-toast" class="fixed bottom-6 right-6 hidden bg-green-600 text-white px-4 py-3 rounded shadow-lg"></div>

    @push('scripts')
    <script>
        (function(){
            const openBtn = document.getElementById('open-create-order');
            const modal = document.getElementById('create-order-modal');
            const closeBtn = document.getElementById('close-create-order');
            const cancelBtn = document.getElementById('cancel-create');
            const vendorBtn = document.getElementById('vendor-btn');
            const vendorList = document.getElementById('vendor-list');
            const vendorLabel = document.getElementById('vendor-btn-label');
            const productBtn = document.getElementById('product-btn');
            const productList = document.getElementById('product-list');
            const productLabel = document.getElementById('product-btn-label');
            const qtyInput = document.getElementById('quantity-input');
            const dateInput = document.getElementById('date-input');
            const submitBtn = document.getElementById('submit-create');
            const toast = document.getElementById('order-toast');
            const tableBody = document.querySelector('table tbody');

            let vendors = [];
            let products = [];
            let selectedVendor = null;
            let selectedProduct = null;

            function openModal(){
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                loadVendors();
            }

            function closeModal(){
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                vendorLabel.textContent = 'Pilih vendor...';
                productLabel.textContent = 'Pilih produk...';
                productBtn.disabled = true;
                qtyInput.value = 1;
                dateInput.value = '';
                selectedVendor = null; selectedProduct = null; products = [];
                updateSummary();
            }

            function slideToast(msg){
                toast.textContent = msg;
                toast.classList.remove('hidden');
                setTimeout(()=> toast.classList.add('hidden'), 3000);
            }

            function formatRp(v){
                if(v === null || v === undefined) return '-';
                return 'Rp ' + Number(v).toLocaleString('id-ID');
            }

            function updateSummary(){
                const summaryEl = document.getElementById('order-summary');
                const qtyVal = Number(qtyInput.value || 0);
                const ready = selectedVendor && selectedProduct && qtyVal > 0;

                if(!ready){
                    if(summaryEl) summaryEl.classList.add('hidden');
                    return;
                }

                if(summaryEl) summaryEl.classList.remove('hidden');
                document.getElementById('summary-product').textContent = selectedProduct?.name || '-';
                document.getElementById('summary-price').textContent = selectedProduct ? formatRp(selectedProduct.price) : '-';
                document.getElementById('summary-qty').textContent = qtyVal ? qtyVal + ' unit' : '-';
                
                // Shipping always '-' as per request
                document.getElementById('summary-shipping').textContent = '-';
                
                // Total is just Price * Qty
                const sub = selectedProduct ? (selectedProduct.price * qtyVal) : 0;
                document.getElementById('summary-total').textContent = selectedProduct ? formatRp(sub) : '-';
            }

            async function loadVendors(){
                try{
                    const res = await fetch('/vendors');
                    if(res.ok) {
                        vendors = await res.json();
                    } else {
                        vendors = [];
                    }

                    vendorList.innerHTML = '';
                    if(vendors.length === 0){
                         const el = document.createElement('div');
                         el.className = 'px-4 py-3 text-neutral-500 italic';
                         el.textContent = 'Tidak ada vendor ditemukan';
                         vendorList.appendChild(el);
                         return;
                    }

                    vendors.forEach(v => {
                        const el = document.createElement('div');
                        el.className = 'px-4 py-3 hover:bg-red-50 cursor-pointer';
                        const label = (v.store_name ? v.store_name + ' ('+v.name+')' : (v.store_name||v.name));
                        el.textContent = label;
                        el.addEventListener('click', ()=> selectVendor(v));
                        vendorList.appendChild(el);
                    });
                }catch(err){
                    console.error(err);
                    vendorList.innerHTML = '<div class="px-4 py-3 text-red-500">Gagal memuat vendor</div>';
                }
            }

            async function selectVendor(v){
                selectedVendor = v;
                vendorLabel.textContent = v.store_name ? v.store_name + ' ('+v.name+')' : (v.store_name||v.name);
                vendorList.classList.add('hidden');

                try{
                    const res = await fetch('/vendors/'+v.id+'/products');
                    products = res.ok ? await res.json() : [];
                    
                    if(products.length === 0){
                         // Fallback for demo if no products found in DB for this vendor
                         // Only if it's the seeded vendor 'Vendor Sadikun'
                         if((v.store_name||'').toLowerCase().includes('sadikun')){
                             products = [
                                { id: 9901, name: 'Gas LPG 12kg', price: 350000 },
                                { id: 9902, name: 'Gas LPG 5.5kg', price: 250000 },
                             ];
                         }
                    }
                }catch(err){
                    console.error(err);
                    products = [];
                }

                productList.innerHTML = '';
                products.forEach(p => {
                    const el = document.createElement('div');
                    el.className = 'px-4 py-3 hover:bg-red-50 cursor-pointer';
                    el.textContent = p.name;
                    el.addEventListener('click', ()=> selectProduct(p));
                    productList.appendChild(el);
                });
                productBtn.disabled = false; productLabel.textContent = 'Pilih produk...'; updateSummary();
            }

            function selectProduct(p){ selectedProduct = p; productLabel.textContent = p.name; productList.classList.add('hidden'); updateSummary(); }

            vendorBtn.addEventListener('click', function(e){ vendorList.classList.toggle('hidden'); productList.classList.add('hidden'); });
            productBtn.addEventListener('click', function(e){ if(!productBtn.disabled) productList.classList.toggle('hidden'); });

            openBtn.addEventListener('click', openModal);
            closeBtn.addEventListener('click', closeModal); 
            cancelBtn.addEventListener('click', closeModal);

            document.addEventListener('click', function(ev){
                if(!vendorBtn.contains(ev.target) && !vendorList.contains(ev.target)) vendorList.classList.add('hidden');
                if(!productBtn.contains(ev.target) && !productList.contains(ev.target)) productList.classList.add('hidden');
            });

            qtyInput.addEventListener('input', updateSummary); 
            dateInput.addEventListener('input', updateSummary);

            submitBtn.addEventListener('click', async function(){
                if(!selectedVendor){ alert('Pilih vendor terlebih dahulu'); return; }
                if(!selectedProduct){ alert('Pilih produk terlebih dahulu'); return; }
                const qty = parseInt(qtyInput.value) || 0; 
                if(qty < 1){ alert('Jumlah minimal 1'); return; }
                submitBtn.disabled = true;
                try{
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const payload = {
                        vendor_name: selectedVendor.name,
                        product_id: selectedProduct.id,
                        product_name: selectedProduct.name,
                        quantity: qty,
                        estimated_delivery: dateInput.value
                    };
                    if(selectedVendor.id) payload.vendor_id = selectedVendor.id;

                    const res = await fetch('/orders', {
                        method: 'POST', 
                        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':token,'Accept':'application/json'},
                        body: JSON.stringify(payload)
                    });
                    const body = await res.json();
                    if(res.ok && body.success){
                        slideToast('Pesanan berhasil dibuat'); 
                        closeModal();
                        setTimeout(()=>location.reload(), 1000);
                    } else {
                        alert(body.message || 'Gagal membuat pesanan');
                    }
                }catch(err){ 
                    console.error(err); 
                    alert('Terjadi kesalahan'); 
                }
                finally{ submitBtn.disabled = false; }
            });

            /* Tracking modal logic */
            const trackingModal = document.getElementById('tracking-modal');
            const trackingCloseBtn = document.getElementById('close-tracking');
            const trackingClose = document.getElementById('tracking-close');
            const trackingConfirm = document.getElementById('tracking-confirm');

            function openTrackingModal(){ trackingModal.classList.remove('hidden'); trackingModal.classList.add('flex'); }
            function closeTrackingModal(){ trackingModal.classList.add('hidden'); trackingModal.classList.remove('flex'); }

            function renderTimeline(items){
                const container = document.getElementById('ti-timeline');
                container.innerHTML = '';
                
                const statusConfig = {
                    'pending': { icon: '✓', color: 'bg-green-50 text-green-600 border-green-200', label: 'Pesanan Dibuat', desc: 'Pesanan telah berhasil dibuat dan menunggu konfirmasi vendor' },
                    'confirmed': { icon: '✓', color: 'bg-blue-50 text-blue-600 border-blue-200', label: 'Dikonfirmasi Vendor', desc: 'Vendor telah mengkonfirmasi pesanan Anda' },
                    'in_progress': { icon: '⚙', color: 'bg-purple-50 text-purple-600 border-purple-200', label: 'Sedang Diproses', desc: 'Pesanan sedang dikemas oleh vendor' },
                    'shipped': { icon: '🚚', color: 'bg-orange-50 text-orange-600 border-orange-200', label: 'Dalam Pengiriman', desc: 'Pesanan sedang dikirim ke lokasi' },
                    'completed': { icon: '✓', color: 'bg-gray-100 text-gray-400 border-gray-200', label: 'Pesanan Selesai', desc: 'Menunggu pesanan selesai' },
                    'rejected': { icon: '✕', color: 'bg-red-50 text-red-600 border-red-200', label: 'Pesanan Ditolak', desc: 'Pesanan ditolak oleh vendor' }
                };
                
                items.forEach((it, index) => {
                    const config = statusConfig[it.status] || statusConfig['pending'];
                    const isLast = index === items.length - 1;
                    const isActive = it.active !== false;
                    
                    const el = document.createElement('div');
                    el.className = 'flex gap-3';
                    el.innerHTML = `
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full ${isActive ? config.color : 'bg-gray-100 text-gray-400 border-gray-200'} border-2 flex items-center justify-center font-semibold flex-shrink-0">
                                ${config.icon}
                            </div>
                            ${!isLast ? '<div class="w-0.5 h-full bg-neutral-200 my-1"></div>' : ''}
                        </div>
                        <div class="flex-1 pb-6">
                            <div class="${isActive ? 'font-semibold text-neutral-900' : 'font-medium text-neutral-400'}">${it.title || config.label}</div>
                            <div class="text-xs ${isActive ? 'text-neutral-500' : 'text-neutral-400'} mt-1">${it.date || ''}</div>
                            <div class="text-sm ${isActive ? 'text-neutral-600' : 'text-neutral-400'} mt-2">${it.description || config.desc}</div>
                            ${it.estimated ? `<div class="text-xs text-neutral-500 mt-2">⏱ Est. tiba: ${it.estimated}</div>` : ''}
                        </div>
                    `;
                    container.appendChild(el);
                });
            }

            async function loadTracking(orderId){
                try{
                    const res = await fetch('/orders/' + orderId + '/tracking');
                    if(!res.ok) {
                        const errorText = await res.text();
                        console.error('Response error:', errorText);
                        throw new Error('Tidak dapat memuat tracking (Status: ' + res.status + ')');
                    }
                    const body = await res.json();
                    console.log('Tracking data:', body);
                    
                    if(body.error) {
                        throw new Error(body.message || 'Server error');
                    }
                    
                    const o = body.order;
                    document.getElementById('ti-order-number').textContent = o.order_number || '-';
                    document.getElementById('tracking-sub').textContent = (o.order_number || '') + ' - ' + (body.status_label || '');
                    document.getElementById('ti-order-date').textContent = new Date(o.created_at).toLocaleString('id-ID');
                    document.getElementById('ti-product').textContent = o.product_name || '-';
                    document.getElementById('ti-qty').textContent = (o.quantity || '-') + ' unit';
                    document.getElementById('ti-total').textContent = formatRp(o.total_price);
                    if(body.vendor){
                        document.getElementById('ti-vendor-name').textContent = body.vendor.store_name || body.vendor.name || '-';
                        document.getElementById('ti-vendor-phone').textContent = body.vendor.phone || '-';
                        document.getElementById('ti-vendor-email').textContent = body.vendor.email || '-';
                        document.getElementById('ti-vendor-avatar').textContent = (body.vendor.store_name || body.vendor.name || 'V').charAt(0).toUpperCase();
                    } else {
                        document.getElementById('ti-vendor-name').textContent = o.vendor_name || '-';
                        document.getElementById('ti-vendor-phone').textContent = '-';
                        document.getElementById('ti-vendor-email').textContent = '-';
                        document.getElementById('ti-vendor-avatar').textContent = (o.vendor_name||'V').charAt(0).toUpperCase();
                    }
                    document.getElementById('ti-resi').textContent = body.tracking_number || '-';
                    renderTimeline(body.timeline || []);
                    trackingConfirm.dataset.orderId = orderId;
                    
                    // Only enable if status is 'shipped'
                    const isShipped = body.order.status === 'shipped';
                    trackingConfirm.disabled = !isShipped;
                    if(isShipped){
                        trackingConfirm.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        trackingConfirm.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                    openTrackingModal();
                }catch(err){ 
                    console.error('Tracking error:', err); 
                    alert('Gagal mengambil data tracking: ' + err.message); 
                }
            }

            document.querySelector('table').addEventListener('click', function(e){
                const btn = e.target.closest('.btn-tracking');
                if(!btn) return;
                const id = btn.dataset.id;
                if(!id) return;
                loadTracking(id);
            });

            if(trackingCloseBtn) trackingCloseBtn.addEventListener('click', closeTrackingModal);
            if(trackingClose) trackingClose.addEventListener('click', closeTrackingModal);

            trackingConfirm.addEventListener('click', async function(){
                const id = this.dataset.orderId; if(!id) return;
                if(!confirm('Konfirmasi terima pesanan?')) return;
                try{
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const res = await fetch('/orders/' + id + '/confirm', { method: 'POST', headers: {'X-CSRF-TOKEN': token, 'Accept':'application/json'} });
                    const body = await res.json();
                    if(res.ok && body.success){ slideToast('Pesanan ditandai selesai'); closeTrackingModal(); setTimeout(()=>location.reload(),600); }
                    else alert(body.message || 'Gagal konfirmasi');
                }catch(err){ console.error(err); alert('Terjadi kesalahan'); }
            });
        })();
    </script>
    @endpush
    @push('scripts')
    <script>
        (function(){
            const form = document.getElementById('manager-filters');
            const qInput = document.getElementById('search-input');
            const status = document.getElementById('status-filter');
            if(!form) return;
            if(status) status.addEventListener('change', ()=> form.submit());

            let t;
            if(qInput){
                qInput.addEventListener('input', function(){ clearTimeout(t); t = setTimeout(()=> form.submit(), 500); });
                qInput.addEventListener('keydown', function(e){ if(e.key === 'Enter'){ e.preventDefault(); form.submit(); } });
            }
        })();
    </script>
    @endpush
</x-app-layout>
