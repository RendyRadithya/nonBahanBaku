<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900">Riwayat Pesanan</h1>
                <p class="text-sm text-neutral-600 mt-1">Lihat dan kelola semua riwayat pesanan bahan baku</p>
            </div>

            <!-- Export Button -->
            <div class="flex items-center gap-3">
                <a href="{{ route('order.history.export', request()->query()) }}" class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-3 py-2 sm:px-4 sm:py-2.5 text-sm bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition whitespace-nowrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Total Pesanan -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Total Pesanan</div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-neutral-900">{{ number_format($stats['total']) }}</div>
                <div class="text-xs text-neutral-500 mt-1">Semua pesanan</div>
            </div>

            <!-- Pesanan Selesai -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Pesanan Selesai</div>
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-neutral-900">{{ number_format($stats['completed']) }}</div>
                <div class="text-xs text-neutral-500 mt-1">Berhasil diterima</div>
            </div>

            <!-- Pesanan Ditolak -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Pesanan Ditolak</div>
                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-neutral-900">{{ number_format($stats['rejected']) }}</div>
                <div class="text-xs text-neutral-500 mt-1">Ditolak vendor</div>
            </div>

            <!-- Total Pengeluaran -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Total Pengeluaran</div>
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-neutral-900">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</div>
                <div class="text-xs text-neutral-500 mt-1">Dari pesanan selesai</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-sm border border-neutral-200 mb-6">
            <div class="p-6">
                <h3 class="text-sm font-semibold text-neutral-700 mb-4">Filter Pesanan</h3>
                <form method="GET" action="{{ route('order.history') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <!-- Search + Reset -->
                    <div class="md:col-span-2">
                        <label class="block text-xs text-neutral-500 mb-1">Cari Pesanan</label>
                        <div class="flex items-center gap-2">
                            <div class="relative flex-1">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="No. pesanan, produk, vendor..." class="w-full pl-10 pr-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            </div>
                            <a href="{{ route('order.history') }}" class="px-3 py-2 bg-neutral-200 text-neutral-700 rounded-lg text-sm hover:bg-neutral-300 transition">Reset</a>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-xs text-neutral-500 mb-1">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Diproses</option>
                            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <!-- Vendor Filter -->
                    <div>
                        <label class="block text-xs text-neutral-500 mb-1">Vendor</label>
                        <select name="vendor" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="">Semua Vendor</option>
                            @foreach($vendors as $v)
                                <option value="{{ $v }}" {{ request('vendor') === $v ? 'selected' : '' }}>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="md:col-span-1">
                        <label class="block text-xs text-neutral-500 mb-1">Dari Tanggal</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" min="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>

                    <!-- Date To -->
                    <div class="md:col-span-1">
                        <label class="block text-xs text-neutral-500 mb-1">Sampai Tanggal</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" min="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>

                    <!-- Filter Actions -->
                    <div class="md:col-span-6 flex items-center justify-end gap-2">
                        <button type="submit" class="w-full md:w-auto px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                            Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-xl shadow-sm border border-neutral-200">
            <div class="p-6 border-b border-neutral-200">
                <h2 class="text-lg font-bold text-neutral-900">Daftar Riwayat Pesanan</h2>
                <p class="text-sm text-neutral-600 mt-1">Menampilkan {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} dari {{ $orders->total() }} pesanan</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-max w-full">
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
                                    @php
                                        $s = strtolower($order->status ?? '');
                                        $badgeClass = 'bg-gray-100 text-gray-700';
                                        $label = ucfirst($order->status);
                                        
                                        switch($s){
                                            case 'confirmed':
                                                $badgeClass = 'bg-green-100 text-green-700';
                                                $label = 'Dikonfirmasi';
                                                break;
                                            case 'rejected':
                                                $badgeClass = 'bg-red-100 text-red-700';
                                                $label = 'Ditolak';
                                                break;
                                            case 'pending':
                                                $badgeClass = 'bg-yellow-100 text-yellow-700';
                                                $label = 'Menunggu';
                                                break;
                                            case 'in_progress':
                                                $badgeClass = 'bg-blue-100 text-blue-700';
                                                $label = 'Diproses';
                                                break;
                                            case 'shipped':
                                                $badgeClass = 'bg-purple-100 text-purple-700';
                                                $label = 'Dikirim';
                                                break;
                                            case 'completed':
                                                $badgeClass = 'bg-green-100 text-green-700';
                                                $label = 'Selesai';
                                                break;
                                        }
                                    @endphp
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $badgeClass }}">{{ $label }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-600">
                                    {{ $order->estimated_delivery ? \Carbon\Carbon::parse($order->estimated_delivery)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <!-- View Detail -->
                                        <button onclick="showOrderDetail({{ $order->id }})" class="p-2 text-neutral-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                        <!-- Download Invoice -->
                                        <a href="{{ route('orders.invoice.download', $order->id) }}" target="_blank" class="p-2 text-neutral-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition" title="Download Invoice">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <p class="text-neutral-500 text-lg font-medium">Tidak ada pesanan ditemukan</p>
                                        <p class="text-neutral-400 text-sm mt-1">Coba ubah filter pencarian Anda</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-neutral-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Order Detail Modal -->
    <div id="order-detail-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-neutral-200 flex items-center justify-between">
                <h3 class="text-xl font-bold text-neutral-900">Detail Pesanan</h3>
                <button onclick="closeOrderDetail()" class="p-2 hover:bg-neutral-100 rounded-lg transition">
                    <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div id="order-detail-content" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Order details data
        const ordersData = @json($orders->items());

        function showOrderDetail(orderId) {
            const order = ordersData.find(o => o.id === orderId);
            if (!order) return;

            const statusMap = {
                'pending': { label: 'Menunggu Konfirmasi', class: 'bg-yellow-100 text-yellow-700' },
                'confirmed': { label: 'Dikonfirmasi', class: 'bg-green-100 text-green-700' },
                'rejected': { label: 'Ditolak', class: 'bg-red-100 text-red-700' },
                'in_progress': { label: 'Sedang Diproses', class: 'bg-blue-100 text-blue-700' },
                'shipped': { label: 'Dikirim', class: 'bg-purple-100 text-purple-700' },
                'completed': { label: 'Selesai', class: 'bg-green-100 text-green-700' }
            };

            const status = statusMap[order.status] || { label: order.status, class: 'bg-gray-100 text-gray-700' };
            const createdAt = new Date(order.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
            const estDelivery = order.estimated_delivery ? new Date(order.estimated_delivery).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }) : '-';

            document.getElementById('order-detail-content').innerHTML = `
                <div class="space-y-6">
                    <!-- Order Number & Status -->
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-neutral-500">No. Pesanan</p>
                            <p class="text-xl font-bold text-neutral-900">${order.order_number}</p>
                        </div>
                        <span class="px-4 py-2 text-sm font-medium rounded-full ${status.class}">${status.label}</span>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-neutral-50 rounded-lg p-4">
                            <p class="text-xs text-neutral-500 mb-1">Tanggal Pesanan</p>
                            <p class="font-semibold text-neutral-900">${createdAt}</p>
                        </div>
                        <div class="bg-neutral-50 rounded-lg p-4">
                            <p class="text-xs text-neutral-500 mb-1">Est. Pengiriman</p>
                            <p class="font-semibold text-neutral-900">${estDelivery}</p>
                        </div>
                        <div class="bg-neutral-50 rounded-lg p-4">
                            <p class="text-xs text-neutral-500 mb-1">Vendor</p>
                            <p class="font-semibold text-neutral-900">${order.vendor_name}</p>
                        </div>
                        <div class="bg-neutral-50 rounded-lg p-4">
                            <p class="text-xs text-neutral-500 mb-1">Produk</p>
                            <p class="font-semibold text-neutral-900">${order.product_name}</p>
                        </div>
                    </div>

                    <!-- Price Details -->
                    <div class="bg-red-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-neutral-600">Jumlah</span>
                            <span class="font-medium">${order.quantity} item</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-red-100">
                            <span class="text-neutral-900 font-semibold">Total Harga</span>
                            <span class="text-xl font-bold text-red-600">Rp ${Number(order.total_price).toLocaleString('id-ID')}</span>
                        </div>
                    </div>

                    ${order.rejection_reason ? `
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-sm font-semibold text-red-700 mb-1">Alasan Penolakan:</p>
                        <p class="text-sm text-red-600">${order.rejection_reason}</p>
                    </div>
                    ` : ''}

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4">
                        <a href="/orders/${order.id}/invoice/download" target="_blank" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Lihat Invoice
                        </a>
                        <button onclick="closeOrderDetail()" class="flex-1 px-4 py-3 bg-neutral-200 text-neutral-700 rounded-lg font-semibold hover:bg-neutral-300 transition">
                            Tutup
                        </button>
                    </div>
                </div>
            `;

            document.getElementById('order-detail-modal').classList.remove('hidden');
        }

        function closeOrderDetail() {
            document.getElementById('order-detail-modal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('order-detail-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeOrderDetail();
            }
        });
    </script>
    @endpush
</x-app-layout>
