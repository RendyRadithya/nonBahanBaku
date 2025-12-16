<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-6">
        <!-- Page Header -->
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900">Katalog Produk</h1>
                <p class="text-sm text-neutral-600 mt-1">Jelajahi produk dari berbagai vendor</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Total Produk -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Total Produk</div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-neutral-900">{{ number_format($stats['total_products']) }}</div>
                <div class="text-xs text-neutral-500 mt-1">Produk terdaftar</div>
            </div>

            <!-- Total Vendor -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Total Vendor</div>
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-neutral-900">{{ number_format($stats['total_vendors']) }}</div>
                <div class="text-xs text-neutral-500 mt-1">Vendor aktif</div>
            </div>

            <!-- Stok Tersedia -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Stok Tersedia</div>
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-neutral-900">{{ number_format($stats['in_stock']) }}</div>
                <div class="text-xs text-neutral-500 mt-1">Produk ready</div>
            </div>

            <!-- Stok Habis -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Stok Habis</div>
                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-neutral-900">{{ number_format($stats['out_of_stock']) }}</div>
                <div class="text-xs text-neutral-500 mt-1">Perlu restock</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-sm border border-neutral-200 mb-6">
            <div class="p-6">
                <h3 class="text-sm font-semibold text-neutral-700 mb-4">Filter Produk</h3>
                <form method="GET" action="{{ route('catalog') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label class="block text-xs text-neutral-500 mb-1">Cari Produk</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama produk..." class="w-full pl-10 pr-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- Vendor Filter -->
                    <div>
                        <label class="block text-xs text-neutral-500 mb-1">Vendor</label>
                        <select name="vendor" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="">Semua Vendor</option>
                            @foreach($vendors as $v)
                                <option value="{{ $v->id }}" {{ request('vendor') == $v->id ? 'selected' : '' }}>{{ $v->store_name ?? $v->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Min Price -->
                    <div>
                        <label class="block text-xs text-neutral-500 mb-1">Harga Min</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>

                    <!-- Max Price -->
                    <div>
                        <label class="block text-xs text-neutral-500 mb-1">Harga Max</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="999999" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>

                    <!-- In Stock Only -->
                    <div class="flex items-end">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} class="w-4 h-4 text-red-600 border-neutral-300 rounded focus:ring-red-500">
                            <span class="text-sm text-neutral-700">Stok tersedia saja</span>
                        </label>
                    </div>

                    <!-- Filter Actions -->
                    <div class="md:col-span-6 flex items-center gap-3 pt-2">
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                            Filter
                        </button>
                        <a href="{{ route('catalog') }}" class="px-6 py-2 bg-neutral-200 text-neutral-700 rounded-lg font-semibold hover:bg-neutral-300 transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="mb-4">
            <p class="text-sm text-neutral-600">Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk</p>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden hover:shadow-lg transition group">
                        <!-- Product Image -->
                        <div class="relative h-48 bg-neutral-100 overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Stock Badge -->
                            @if($product->stock > 0)
                                <span class="absolute top-3 right-3 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Stok: {{ $product->stock }}
                                </span>
                            @else
                                <span class="absolute top-3 right-3 px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                    Habis
                                </span>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <!-- Vendor Badge -->
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-xs font-bold">
                                    {{ strtoupper(substr($product->vendor->store_name ?? $product->vendor->name ?? 'V', 0, 1)) }}
                                </div>
                                <span class="text-xs text-neutral-500">{{ $product->vendor->store_name ?? $product->vendor->name ?? 'Unknown Vendor' }}</span>
                            </div>

                            <!-- Product Name -->
                            <h3 class="font-semibold text-neutral-900 mb-1 line-clamp-2">{{ $product->name }}</h3>
                            
                            <!-- Description -->
                            @if($product->description)
                                <p class="text-xs text-neutral-500 mb-3 line-clamp-2">{{ $product->description }}</p>
                            @endif

                            <!-- Price -->
                            <div class="text-lg font-bold text-red-600 mb-3">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </div>

                            <!-- Action Button -->
                            @if($product->stock > 0)
                                <button onclick="openOrderModal({{ json_encode($product) }})" class="w-full py-2.5 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Pesan Sekarang
                                </button>
                            @else
                                <button disabled class="w-full py-2.5 bg-neutral-200 text-neutral-500 rounded-lg font-semibold cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-12">
                <div class="flex flex-col items-center">
                    <svg class="w-20 h-20 text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="text-neutral-500 text-lg font-medium">Tidak ada produk ditemukan</p>
                    <p class="text-neutral-400 text-sm mt-1">Coba ubah filter pencarian Anda</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Order Modal -->
    <div id="order-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
            <div class="p-6 border-b border-neutral-200 flex items-center justify-between">
                <h3 class="text-xl font-bold text-neutral-900">Buat Pesanan</h3>
                <button onclick="closeOrderModal()" class="p-2 hover:bg-neutral-100 rounded-lg transition">
                    <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form id="quick-order-form" class="p-6">
                @csrf
                <input type="hidden" id="modal-product-id" name="product_id">
                <input type="hidden" id="modal-vendor-id" name="vendor_id">
                <input type="hidden" id="modal-vendor-name" name="vendor_name">
                <input type="hidden" id="modal-product-name" name="product_name">

                <!-- Product Info -->
                <div class="bg-neutral-50 rounded-lg p-4 mb-4">
                    <div class="flex items-start gap-4">
                        <div id="modal-product-image" class="w-16 h-16 bg-neutral-200 rounded-lg flex items-center justify-center overflow-hidden">
                            <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p id="modal-product-title" class="font-semibold text-neutral-900"></p>
                            <p id="modal-vendor-title" class="text-sm text-neutral-500"></p>
                            <p id="modal-product-price" class="text-red-600 font-bold mt-1"></p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Jumlah</label>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="decrementQty()" class="w-10 h-10 rounded-lg border border-neutral-300 flex items-center justify-center hover:bg-neutral-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <input type="number" id="modal-quantity" name="quantity" value="1" min="1" class="w-20 text-center py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <button type="button" onclick="incrementQty()" class="w-10 h-10 rounded-lg border border-neutral-300 flex items-center justify-center hover:bg-neutral-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        <span id="modal-stock-info" class="text-sm text-neutral-500"></span>
                    </div>
                </div>

                <!-- Estimated Delivery -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-neutral-700 mb-2">Estimasi Pengiriman</label>
                    <input type="date" id="modal-delivery-date" name="estimated_delivery" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" required>
                </div>

                <!-- Total -->
                <div class="bg-red-50 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-neutral-700 font-semibold">Total Harga</span>
                        <span id="modal-total-price" class="text-xl font-bold text-red-600">Rp 0</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button type="button" onclick="closeOrderModal()" class="flex-1 px-4 py-3 bg-neutral-200 text-neutral-700 rounded-lg font-semibold hover:bg-neutral-300 transition">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                        Buat Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Toast -->
    <div id="success-toast" class="hidden fixed top-4 right-4 z-50">
        <div class="bg-green-600 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span id="success-message">Pesanan berhasil dibuat!</span>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentProduct = null;
        let productPrice = 0;
        let maxStock = 0;

        function openOrderModal(product) {
            currentProduct = product;
            productPrice = parseFloat(product.price);
            maxStock = product.stock;

            // Set form values
            document.getElementById('modal-product-id').value = product.id;
            document.getElementById('modal-vendor-id').value = product.vendor_id;
            document.getElementById('modal-vendor-name').value = product.vendor?.store_name || product.vendor?.name || '';
            document.getElementById('modal-product-name').value = product.name;

            // Set display values
            document.getElementById('modal-product-title').textContent = product.name;
            document.getElementById('modal-vendor-title').textContent = product.vendor?.store_name || product.vendor?.name || 'Unknown Vendor';
            document.getElementById('modal-product-price').textContent = 'Rp ' + formatNumber(productPrice) + ' / item';
            document.getElementById('modal-stock-info').textContent = 'Stok: ' + maxStock;

            // Set image
            const imageContainer = document.getElementById('modal-product-image');
            if (product.image) {
                imageContainer.innerHTML = `<img src="/storage/${product.image}" class="w-full h-full object-cover">`;
            } else {
                imageContainer.innerHTML = `<svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>`;
            }

            // Reset quantity
            document.getElementById('modal-quantity').value = 1;
            document.getElementById('modal-quantity').max = maxStock;
            updateTotalPrice();

            // Set minimum delivery date (tomorrow)
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            document.getElementById('modal-delivery-date').min = tomorrow.toISOString().split('T')[0];
            document.getElementById('modal-delivery-date').value = tomorrow.toISOString().split('T')[0];

            // Show modal
            document.getElementById('order-modal').classList.remove('hidden');
        }

        function closeOrderModal() {
            document.getElementById('order-modal').classList.add('hidden');
            currentProduct = null;
        }

        function incrementQty() {
            const input = document.getElementById('modal-quantity');
            const current = parseInt(input.value) || 1;
            if (current < maxStock) {
                input.value = current + 1;
                updateTotalPrice();
            }
        }

        function decrementQty() {
            const input = document.getElementById('modal-quantity');
            const current = parseInt(input.value) || 1;
            if (current > 1) {
                input.value = current - 1;
                updateTotalPrice();
            }
        }

        function updateTotalPrice() {
            const qty = parseInt(document.getElementById('modal-quantity').value) || 1;
            const total = productPrice * qty;
            document.getElementById('modal-total-price').textContent = 'Rp ' + formatNumber(total);
        }

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Update total when quantity changes
        document.getElementById('modal-quantity').addEventListener('input', function() {
            let val = parseInt(this.value) || 1;
            if (val < 1) val = 1;
            if (val > maxStock) val = maxStock;
            this.value = val;
            updateTotalPrice();
        });

        // Close modal when clicking outside
        document.getElementById('order-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeOrderModal();
            }
        });

        // Handle form submission
        document.getElementById('quick-order-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = {
                _token: '{{ csrf_token() }}',
                vendor_id: document.getElementById('modal-vendor-id').value,
                vendor_name: document.getElementById('modal-vendor-name').value,
                product_id: document.getElementById('modal-product-id').value,
                product_name: document.getElementById('modal-product-name').value,
                quantity: document.getElementById('modal-quantity').value,
                estimated_delivery: document.getElementById('modal-delivery-date').value,
            };

            try {
                const response = await fetch('/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (data.success) {
                    closeOrderModal();
                    showSuccessToast('Pesanan berhasil dibuat!');
                    // Reload page after 1.5 seconds
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    alert(data.message || 'Gagal membuat pesanan');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });

        function showSuccessToast(message) {
            document.getElementById('success-message').textContent = message;
            const toast = document.getElementById('success-toast');
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
    </script>
    @endpush
</x-app-layout>
