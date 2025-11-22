<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - McOrder</title>
        <!-- Poppins font to match design -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-50">
    <div class="min-h-screen">
        <!-- Top navigation -->
        <header class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <a href="/" class="flex items-center gap-3">
                        <img src="{{ asset('images/Logo MCorder.png') }}" alt="McOrder" class="w-12 object-contain" />
                    </a>
                    <nav>
                        <a href="/dashboard" class="inline-flex items-center gap-2 text-sm font-medium text-red-600 pb-2 border-b-2 border-red-600">Dashboard</a>
                    </nav>
                </div>

                <div class="flex items-center gap-4">
                    <button class="p-2 rounded-full hover:bg-neutral-100" title="Notifikasi">
                        <svg class="w-5 h-5 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </button>

                    <div class="relative">
                        <button id="account-btn" class="flex items-center gap-3 px-3 py-1 rounded-full hover:bg-neutral-100">
                            <div class="text-sm text-neutral-700 text-right">
                                <div class="font-medium">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-neutral-500">{{ auth()->user()->store_name ?? '' }}</div>
                            </div>
                            <div class="w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center font-semibold">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                        </button>
                        <div id="account-menu" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-50">
                            <div class="p-3 text-sm text-neutral-700">
                                <div class="font-medium">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-neutral-500"><a href="#" class="hover:underline">{{ auth()->user()->store_name ?? '' }}</a></div>
                            </div>
                            <div class="border-t"></div>
                            <a href="/profile" class="block w-full text-left px-4 py-3 text-sm text-neutral-700 hover:bg-neutral-50">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-neutral-50">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-6">
            <!-- Page Header -->
            <div class="flex items-start justify-between mb-6">
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-semibold text-neutral-900">Dashboard</h1>
                        <div class="w-24 h-0.5 bg-red-600 rounded mt-6"></div>
                    </div>
                    <p class="text-sm text-neutral-600 mt-2">Kelola dan pantau pesanan bahan baku non-HAVI</p>
                </div>

                <!-- right side intentionally empty here; controls live in top navigation -->
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                    <div class="text-sm text-neutral-500">Total Pesanan</div>
                    <div class="mt-3 text-3xl font-bold text-neutral-900">{{ $totalOrders ?? 0 }}</div>
                    <div class="text-xs text-neutral-400 mt-1">Semua pesanan (kecuali selesai)</div>
                </div>
                <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                    <div class="text-sm text-neutral-500">Menunggu Konfirmasi</div>
                    <div class="mt-3 text-3xl font-bold text-neutral-900">{{ $pendingOrders ?? 0 }}</div>
                    <div class="text-xs text-neutral-400 mt-1">Perlu ditindaklanjuti</div>
                </div>
                <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                    <div class="text-sm text-neutral-500">Sedang Diproses</div>
                    <div class="mt-3 text-3xl font-bold text-neutral-900">{{ $inProgressOrders ?? 0 }}</div>
                    <div class="text-xs text-neutral-400 mt-1">Dalam pengiriman</div>
                </div>
                <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                    <div class="text-sm text-neutral-500">Selesai</div>
                    <div class="mt-3 text-3xl font-bold text-neutral-900">{{ $completedOrders ?? 0 }}</div>
                    <div class="text-xs text-neutral-400 mt-1">Pesanan selesai</div>
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
                            <button id="open-create-order" class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
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
        </main>
    </div>
            <!-- Tracking Modal -->
            <div id="tracking-modal" class="fixed inset-0 hidden items-center justify-center z-50" style="background-color: rgba(0,0,0,0.08);">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4">
                    <div class="flex items-center justify-between px-5 py-4 border-b">
                        <div>
                            <h3 id="tracking-title" class="text-lg font-semibold">Tracking Pesanan</h3>
                            <div id="tracking-sub" class="text-sm text-neutral-500">ORD-xxxx - Status</div>
                        </div>
                        <button id="close-tracking" class="text-neutral-500 hover:text-neutral-800">✕</button>
                    </div>
                    <div class="p-5 font-sans text-sm space-y-4">
                        <!-- Informasi Pesanan -->
                        <div class="border rounded-lg p-4 bg-neutral-50">
                            <h4 class="font-semibold mb-2">Informasi Pesanan</h4>
                            <div class="grid grid-cols-2 gap-2 text-sm text-neutral-700">
                                <div>No. Pesanan</div><div class="text-right font-medium" id="ti-order-number">-</div>
                                <div>Tanggal Pesan</div><div class="text-right" id="ti-order-date">-</div>
                                <div>Produk</div><div class="text-right" id="ti-product">-</div>
                                <div>Jumlah</div><div class="text-right" id="ti-qty">-</div>
                                <div>Total Harga</div><div class="text-right font-medium text-red-600" id="ti-total">-</div>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="border rounded-lg p-4 bg-white">
                            <h4 class="font-semibold mb-4">Timeline Pengiriman</h4>
                            <div id="ti-timeline" class="space-y-4 text-sm text-neutral-700">
                                <!-- timeline items inserted here -->
                            </div>
                        </div>

                        <!-- Informasi Vendor -->
                        <div class="border rounded-lg p-4 bg-neutral-50">
                            <h4 class="font-semibold mb-2">Informasi Vendor</h4>
                            <div class="flex items-center gap-4">
                                <div id="ti-vendor-avatar" class="w-10 h-10 rounded-full bg-red-600 text-white flex items-center justify-center font-semibold">V</div>
                                <div class="flex-1">
                                    <div id="ti-vendor-name" class="font-medium">-</div>
                                    <div id="ti-vendor-sub" class="text-xs text-neutral-500">Vendor Terpercaya</div>
                                    <div class="text-xs text-neutral-600 mt-2">
                                        <div id="ti-vendor-phone"></div>
                                        <div id="ti-vendor-email"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block text-xs text-neutral-500 mb-1">No. Resi Pengiriman</label>
                                <div id="ti-resi" class="bg-white border px-3 py-2 rounded text-sm text-neutral-700">-</div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <button id="tracking-close" class="px-4 py-2 rounded-lg border">Tutup</button>
                            <button id="tracking-confirm" class="px-4 py-2 rounded-lg bg-red-600 text-white">Konfirmasi Terima</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Order Modal -->
            <div id="create-order-modal" class="fixed inset-0 hidden items-center justify-center z-50" style="background-color: rgba(0,0,0,0.08);">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
                    <div class="flex items-center justify-between px-5 py-4 border-b">
                        <h3 class="text-lg font-semibold">Buat Pesanan Baru</h3>
                        <button id="close-create-order" class="text-neutral-500 hover:text-neutral-800">✕</button>
                    </div>
                    <div class="p-5 font-sans text-sm">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Pilih Vendor</label>
                            <div class="relative">
                                <button id="vendor-btn" type="button" class="w-full text-left border px-3 py-2 rounded-lg bg-white flex items-center justify-between">
                                    <span id="vendor-btn-label" class="text-neutral-600">Pilih vendor...</span>
                                    <svg class="w-4 h-4 text-neutral-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.12 1.02l-4.25 4.66a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd"/></svg>
                                </button>
                                <div id="vendor-list" class="hidden absolute left-0 right-0 mt-2 bg-white border rounded-lg shadow-lg max-h-56 overflow-auto z-40">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Produk</label>
                            <div class="relative">
                                <button id="product-btn" type="button" class="w-full text-left border px-3 py-2 rounded-lg bg-white flex items-center justify-between disabled:opacity-60" disabled>
                                    <span id="product-btn-label" class="text-neutral-600">Pilih produk...</span>
                                    <svg class="w-4 h-4 text-neutral-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.12 1.02l-4.25 4.66a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd"/></svg>
                                </button>
                                <div id="product-list" class="hidden absolute left-0 right-0 mt-2 bg-white border rounded-lg shadow-lg max-h-56 overflow-auto z-40">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Jumlah</label>
                            <input id="quantity-input" type="number" min="1" value="1" class="w-full border px-3 py-2 rounded-lg" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-neutral-700 mb-1">Tanggal Pengiriman Diharapkan</label>
                            <input id="date-input" type="date" class="w-full border px-3 py-2 rounded-lg" />
                        </div>

                        <div id="order-summary" class="mb-4 border rounded-lg p-3 bg-neutral-50 hidden">
                            <h4 class="text-sm font-semibold mb-2 flex items-center gap-2"><span class="text-red-500">📦</span> Ringkasan Pesanan</h4>
                            <div class="grid grid-cols-2 gap-2 text-sm text-neutral-700">
                                <div>Produk</div><div class="text-right font-medium" id="summary-product">-</div>
                                <div>Harga Satuan</div><div class="text-right font-medium" id="summary-price">-</div>
                                <div>Jumlah</div><div class="text-right font-medium" id="summary-qty">-</div>
                                <div>Subtotal</div><div class="text-right font-medium" id="summary-sub">-</div>
                                <div>Biaya Pengiriman (Est.)</div><div class="text-right font-medium" id="summary-shipping">-</div>
                            </div>

                            <div class="mt-3 pt-3 border-t flex items-center justify-between">
                                <div class="text-sm text-neutral-500">Total Harga</div>
                                <div class="text-lg font-bold text-red-600" id="summary-total">-</div>
                            </div>
                            <p class="mt-3 text-xs text-blue-700 bg-blue-50 p-2 rounded">Catatan: Harga dan biaya pengiriman bersifat estimasi. Harga final akan dikonfirmasi oleh vendor.</p>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <button id="cancel-create" class="px-4 py-2 rounded-lg border">Batal</button>
                            <button id="submit-create" class="px-4 py-2 rounded-lg bg-red-600 text-white">Buat Pesanan</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toast -->
            <div id="order-toast" class="fixed bottom-6 right-6 hidden bg-green-600 text-white px-4 py-3 rounded shadow-lg"></div>

            <script>
                (function(){
                    const openBtn = document.getElementById('open-create-order');
                    const accountBtn = document.getElementById('account-btn');
                    const accountMenu = document.getElementById('account-menu');
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
                        toast.classList.add('translate-y-0','opacity-100');
                        setTimeout(()=>{ toast.classList.remove('translate-y-0'); toast.classList.add('-translate-y-4','opacity-0'); }, 2200);
                        setTimeout(()=>{ toast.classList.add('hidden'); toast.classList.remove('-translate-y-4','opacity-0'); }, 2600);
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
                            // hide summary until vendor+product+qty provided
                            if(summaryEl) summaryEl.classList.add('hidden');
                            document.getElementById('summary-product').textContent = '-';
                            document.getElementById('summary-price').textContent = '-';
                            document.getElementById('summary-qty').textContent = '-';
                            document.getElementById('summary-sub').textContent = '-';
                            document.getElementById('summary-shipping').textContent = '-';
                            document.getElementById('summary-total').textContent = '-';
                            return;
                        }

                        if(summaryEl) summaryEl.classList.remove('hidden');
                        document.getElementById('summary-product').textContent = selectedProduct?.name || '-';
                        document.getElementById('summary-price').textContent = selectedProduct ? formatRp(selectedProduct.price) : '-';
                        document.getElementById('summary-qty').textContent = qtyVal ? qtyVal + ' unit' : '-';
                        const sub = selectedProduct ? (selectedProduct.price * qtyVal) : 0;
                        document.getElementById('summary-sub').textContent = selectedProduct ? formatRp(sub) : '-';
                        const ship = selectedProduct ? 50000 : 0;
                        document.getElementById('summary-shipping').textContent = selectedProduct ? formatRp(ship) : '-';
                        document.getElementById('summary-total').textContent = selectedProduct ? formatRp(sub + ship) : '-';
                    }

                    async function loadVendors(){
                        // predefined vendor list (will be merged with server results)
                        const staticVendors = [
                            { id: 1001, name: 'sadikun', store_name: 'Sadikun', __static: true },
                            { id: 1002, name: 'kencana_emas', store_name: 'Kencana Emas', __static: true },
                            { id: 1003, name: 'akrilik_jaya', store_name: 'Akrilik Jaya', __static: true },
                        ];

                        try{
                            const res = await fetch('/vendors');
                            let fetched = [];
                            if(res.ok) fetched = await res.json();

                            // merge fetched with static (avoid duplicates by store_name)
                            const map = new Map();
                            fetched.forEach(v => map.set((v.store_name||v.name).toLowerCase(), v));
                            staticVendors.forEach(s => { if(!map.has(s.store_name.toLowerCase())) map.set(s.store_name.toLowerCase(), s); });
                            // filter out internal McD vendors (e.g. 'mcd', 'venti')
                            vendors = Array.from(map.values()).filter(v => {
                                const label = (v.store_name || v.name || '').toLowerCase();
                                return !(label.includes('mcd') || label.includes('venti'));
                            });

                            vendorList.innerHTML = '';
                            vendors.forEach(v => {
                                const el = document.createElement('div');
                                el.className = 'px-4 py-3 hover:bg-yellow-300 hover:text-black cursor-pointer';
                                const label = (v.store_name ? v.store_name + ' ('+v.name+')' : (v.store_name||v.name));
                                el.textContent = label;
                                el.dataset.id = v.id; el.dataset.name = v.name; el.dataset.store = v.store_name || v.name;
                                if(v.__static) el.dataset.static = '1';
                                el.addEventListener('click', ()=> selectVendor(v));
                                vendorList.appendChild(el);
                            });
                        }catch(err){ console.error(err);
                            // fallback to static only
                            // fallback to static vendors but also filter McD-like entries
                            vendors = staticVendors.filter(v => { const ln = (v.store_name||v.name).toLowerCase(); return !(ln.includes('mcd') || ln.includes('venti')); });
                            vendorList.innerHTML = '';
                            vendors.forEach(v => {
                                const el = document.createElement('div');
                                el.className = 'px-4 py-3 hover:bg-yellow-300 hover:text-black cursor-pointer';
                                el.textContent = v.store_name;
                                el.dataset.id = v.id; el.dataset.name = v.name; el.dataset.store = v.store_name;
                                el.addEventListener('click', ()=> selectVendor(v));
                                vendorList.appendChild(el);
                            });
                        }
                    }

                    async function selectVendor(v){
                        selectedVendor = v;
                        vendorLabel.textContent = v.store_name ? v.store_name + ' ('+v.name+')' : (v.store_name||v.name);
                        vendorList.classList.add('hidden');

                        // product mapping for specific vendors
                        const staticProducts = {
                            'sadikun': [
                                { id: 2001, name: 'Gas 3kg', price: 150000 },
                                { id: 2002, name: 'Gas 5.5kg', price: 250000 },
                                { id: 2003, name: 'Gas 12kg', price: 350000 },
                            ],
                            'kencana emas': [
                                { id: 3001, name: 'CO₂ Tank 25kg', price: 175000 },
                                { id: 3002, name: 'Translite Menu A3', price: 300000 },
                                { id: 3003, name: 'Translite Menu A4', price: 200000 },
                            ],
                            'akrilik jaya': [
                                { id: 4001, name: 'Akrilik Display Stand', price: 120000 },
                                { id: 4002, name: 'Akrilik Menu Holder', price: 80000 },
                            ]
                        };

                        // try server products first, else use static mapping
                        try{
                            const res = await fetch('/vendors/'+v.id+'/products');
                            let fetched = res.ok ? await res.json() : [];
                            // if server returns none, check static mapping by store_name (lowercase)
                            if(!fetched || fetched.length === 0){
                                const key = (v.store_name || v.name).toLowerCase();
                                fetched = staticProducts[key] || [];
                            }
                            // filter out internal McD products if any
                            products = (fetched || []).filter(p => {
                                const n = (p.name || '').toLowerCase();
                                return !(n.includes('mcd product') || n.includes('mcd'));
                            });
                        }catch(err){
                            const key = (v.store_name || v.name).toLowerCase();
                            products = staticProducts[key] || [];
                        }

                        productList.innerHTML = '';
                        products.forEach(p => {
                            const el = document.createElement('div');
                            el.className = 'px-4 py-3 hover:bg-yellow-300 hover:text-black cursor-pointer';
                            el.textContent = p.name;
                            el.dataset.id = p.id; el.dataset.name = p.name; el.dataset.price = p.price || 0;
                            el.addEventListener('click', ()=> selectProduct(p));
                            productList.appendChild(el);
                        });
                        productBtn.disabled = false; productLabel.textContent = 'Pilih produk...'; updateSummary();
                    }

                    function selectProduct(p){ selectedProduct = p; productLabel.textContent = p.name; productList.classList.add('hidden'); updateSummary(); }

                    vendorBtn.addEventListener('click', function(e){ vendorList.classList.toggle('hidden'); productList.classList.add('hidden'); });
                    productBtn.addEventListener('click', function(e){ if(!productBtn.disabled) productList.classList.toggle('hidden'); });

                    openBtn.addEventListener('click', openModal);
                    closeBtn.addEventListener('click', closeModal); cancelBtn.addEventListener('click', closeModal);

                    // account menu toggle
                    if(accountBtn){
                        accountBtn.addEventListener('click', function(e){
                            e.stopPropagation(); accountMenu.classList.toggle('hidden');
                        });
                        document.addEventListener('click', function(){ if(accountMenu) accountMenu.classList.add('hidden'); });
                    }

                    document.addEventListener('click', function(ev){
                        if(!document.getElementById('vendor-btn').contains(ev.target) && !document.getElementById('vendor-list').contains(ev.target)) vendorList.classList.add('hidden');
                        if(!document.getElementById('product-btn').contains(ev.target) && !document.getElementById('product-list').contains(ev.target)) productList.classList.add('hidden');
                    });

                    qtyInput.addEventListener('input', updateSummary); dateInput.addEventListener('input', updateSummary);

                    submitBtn.addEventListener('click', async function(){
                        if(!selectedVendor){ alert('Pilih vendor terlebih dahulu'); return; }
                        if(!selectedProduct){ alert('Pilih produk terlebih dahulu'); return; }
                        const qty = parseInt(qtyInput.value) || 0; if(qty < 1){ alert('Jumlah minimal 1'); return; }
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
                            // include vendor_id only when vendor is not a synthetic/static vendor
                            if(!selectedVendor.__static && selectedVendor.id) payload.vendor_id = selectedVendor.id;

                            const res = await fetch('/orders', {
                                method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':token,'Accept':'application/json'},
                                body: JSON.stringify(payload)
                            });
                            const body = await res.json();
                            if(res.ok && body.success){
                                // append new row without reload
                                const o = body.order;
                                const tr = document.createElement('tr');
                                tr.className = 'hover:bg-neutral-50 transition';
                                const created = new Date(o.created_at);
                                const createdDate = created.toLocaleDateString('id-ID');
                                const est = o.estimated_delivery ? new Date(o.estimated_delivery).toLocaleDateString('id-ID') : '-';
                                tr.innerHTML = `
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">${o.order_number}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">${createdDate}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900">${o.vendor_name}</td>
                                    <td class="px-6 py-4 text-sm text-neutral-900">${o.product_name}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">${o.quantity}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900">${formatRp(o.total_price)}</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Menunggu</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">${est}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"><div class="flex items-center gap-2"><button class="p-1 hover:bg-neutral-100 rounded transition btn-tracking" data-id="${o.id}" title="Lihat Tracking"><svg class=\"w-5 h-5 text-neutral-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\"/><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\"/></svg></button><button class=\"p-1 hover:bg-neutral-100 rounded transition\" title=\"Download\">⬇</button></div></td>
                                `;
                                if(tableBody) tableBody.insertBefore(tr, tableBody.firstChild);
                                slideToast('Pesanan berhasil dibuat'); closeModal();
                            } else {
                                alert(body.message || 'Gagal membuat pesanan');
                            }
                        }catch(err){ console.error(err); alert('Terjadi kesalahan'); }
                        finally{ submitBtn.disabled = false; }
                    });

                    document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closeModal(); });
                    modal.addEventListener('click', function(e){ if(e.target === modal) closeModal(); });

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
                        items.forEach(it => {
                            const el = document.createElement('div');
                            el.className = 'flex items-start gap-3';
                            el.innerHTML = `
                                <div class=\"w-9 h-9 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-sm font-medium\">${it.icon||'●'}</div>
                                <div class=\"flex-1\"> <div class=\"font-medium\">${it.title}</div> <div class=\"text-xs text-neutral-500 mt-1\">${it.date}</div> <div class=\"text-xs text-neutral-600 mt-2\">${it.description||''}</div></div>
                            `;
                            container.appendChild(el);
                        });
                    }

                    async function loadTracking(orderId){
                        try{
                            const res = await fetch('/orders/' + orderId + '/tracking');
                            if(!res.ok) throw new Error('Tidak dapat memuat tracking');
                            const body = await res.json();
                            const o = body.order;
                            document.getElementById('ti-order-number').textContent = o.order_number || '-';
                            document.getElementById('tracking-title').textContent = 'Tracking Pesanan';
                            document.getElementById('tracking-sub').textContent = (o.order_number || '') + ' - ' + (body.status_label || '');
                            document.getElementById('ti-order-date').textContent = new Date(o.created_at).toLocaleString('id-ID');
                            document.getElementById('ti-product').textContent = o.product_name || '-';
                            document.getElementById('ti-qty').textContent = (o.quantity || '-') + ' unit';
                            document.getElementById('ti-total').textContent = formatRp(o.total_price);
                            // vendor
                            if(body.vendor){
                                document.getElementById('ti-vendor-name').textContent = body.vendor.store_name || body.vendor.name || '-';
                                document.getElementById('ti-vendor-phone').textContent = body.vendor.phone || '';
                                document.getElementById('ti-vendor-email').textContent = body.vendor.email || '';
                                document.getElementById('ti-vendor-avatar').textContent = (body.vendor.store_name || body.vendor.name || 'V').charAt(0).toUpperCase();
                            } else {
                                document.getElementById('ti-vendor-name').textContent = o.vendor_name || '-';
                                document.getElementById('ti-vendor-phone').textContent = '';
                                document.getElementById('ti-vendor-email').textContent = '';
                                document.getElementById('ti-vendor-avatar').textContent = (o.vendor_name||'-').charAt(0).toUpperCase();
                            }
                            document.getElementById('ti-resi').textContent = body.tracking_number || '-';
                            renderTimeline(body.timeline || []);
                            // show confirm if status allows
                            trackingConfirm.dataset.orderId = orderId;
                            trackingConfirm.disabled = body.order.status !== 'in_progress' && body.order.status !== 'shipped' && body.order.status !== 'confirmed';
                            openTrackingModal();
                        }catch(err){ console.error(err); alert('Gagal mengambil data tracking'); }
                    }

                    // handle delegation for tracking buttons in table (existing and newly added rows)
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
</body>
</html>
