@extends('layouts.app')

@section('title', 'Riwayat Pesanan - McOrder')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">📋 Riwayat Pesanan</h1>
                <p class="text-gray-500 mt-2">Semua pesanan yang diterima</p>
            </div>
            <a href="{{ route('vendor.history.export', request()->query()) }}" 
               class="mt-4 sm:mt-0 inline-flex items-center px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </a>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-md p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">Total Pesanan</p>
                        <p class="text-xl font-bold text-gray-800">{{ number_format($stats['total']) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-xl">📦</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">Pesanan Selesai</p>
                        <p class="text-xl font-bold text-green-600">{{ number_format($stats['completed']) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-xl">✅</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">Pesanan Ditolak</p>
                        <p class="text-xl font-bold text-red-600">{{ number_format($stats['rejected']) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <span class="text-xl">❌</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">Total Pendapatan</p>
                        <p class="text-xl font-bold text-green-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                        <span class="text-xl">💰</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <form method="GET" action="{{ route('vendor.history') }}" class="flex items-end gap-3 flex-wrap">
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="No. pesanan, produk..." 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                </div>
                <div class="w-40">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <div class="relative">
                        <select name="status" class="w-full pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 appearance-none">
                            <option value="">Semua</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Diproses</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="w-40">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                </div>
                <div class="w-40">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                    <button type="submit" class="w-full px-5 py-2.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-medium">
                        Cari
                    </button>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                    <a href="{{ route('vendor.history') }}" class="block px-5 py-2.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition font-medium text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">No. Pesanan</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Tanggal</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Toko</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Produk</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Qty</th>
                                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Total</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($orders as $order)
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'confirmed' => 'bg-blue-100 text-blue-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        'in_progress' => 'bg-purple-100 text-purple-700',
                                        'shipped' => 'bg-cyan-100 text-cyan-700',
                                        'completed' => 'bg-green-100 text-green-700',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu',
                                        'confirmed' => 'Dikonfirmasi',
                                        'rejected' => 'Ditolak',
                                        'in_progress' => 'Diproses',
                                        'shipped' => 'Dikirim',
                                        'completed' => 'Selesai',
                                    ];
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        <span class="font-medium text-gray-800">{{ $order->order_number }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $order->created_at->format('d/m/Y') }}
                                        <br>
                                        <span class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $order->user->store_name ?? '-' }}</p>
                                            <p class="text-xs text-gray-500">{{ $order->user->name ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-800">{{ $order->product_name }}</td>
                                    <td class="px-4 py-3 text-center text-gray-800">{{ number_format($order->quantity) }}</td>
                                    <td class="px-4 py-3 text-right font-semibold text-gray-800">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ $statusLabels[$order->status] ?? $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button onclick="showOrderDetail({{ $order->id }})" 
                                                class="text-blue-600 hover:text-blue-800 transition" title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <span class="text-6xl">📋</span>
                    <p class="mt-4 text-gray-500 text-lg">Belum ada riwayat pesanan</p>
                    <p class="text-gray-400">Pesanan yang diterima akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Order Detail Modal -->
<div id="orderDetailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-800">📋 Detail Pesanan</h3>
            <button onclick="closeOrderDetail()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="orderDetailContent" class="p-6">
            <div class="flex items-center justify-center py-8">
                <svg class="animate-spin h-8 w-8 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<script>
    // Order data for modal
    const ordersData = @json($orders->items());
    
    function showOrderDetail(orderId) {
        const order = ordersData.find(o => o.id === orderId);
        if (!order) return;
        
        const statusLabels = {
            'pending': 'Menunggu',
            'confirmed': 'Dikonfirmasi',
            'rejected': 'Ditolak',
            'in_progress': 'Diproses',
            'shipped': 'Dikirim',
            'completed': 'Selesai',
        };
        
        const statusColors = {
            'pending': 'bg-yellow-100 text-yellow-700',
            'confirmed': 'bg-blue-100 text-blue-700',
            'rejected': 'bg-red-100 text-red-700',
            'in_progress': 'bg-purple-100 text-purple-700',
            'shipped': 'bg-cyan-100 text-cyan-700',
            'completed': 'bg-green-100 text-green-700',
        };
        
        const content = `
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Nomor Pesanan</p>
                        <p class="text-lg font-bold text-gray-800">${order.order_number}</p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold ${statusColors[order.status] || 'bg-gray-100 text-gray-700'}">
                        ${statusLabels[order.status] || order.status}
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Toko</p>
                        <p class="font-semibold text-gray-800">${order.user?.store_name || '-'}</p>
                        <p class="text-sm text-gray-600">${order.user?.name || '-'}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Tanggal Pesanan</p>
                        <p class="font-semibold text-gray-800">${new Date(order.created_at).toLocaleDateString('id-ID')}</p>
                        <p class="text-sm text-gray-600">${new Date(order.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}</p>
                    </div>
                </div>
                
                <div class="bg-yellow-50 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-3">🍔 Detail Produk</h4>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">${order.product_name}</p>
                            <p class="text-sm text-gray-500">Jumlah: ${order.quantity}</p>
                        </div>
                        <p class="font-bold text-lg text-green-600">Rp ${Number(order.total_price).toLocaleString('id-ID')}</p>
                    </div>
                </div>
                
                ${order.notes ? `
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-2">📝 Catatan</h4>
                        <p class="text-gray-600">${order.notes}</p>
                    </div>
                ` : ''}
                
                ${order.tracking_number ? `
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-2">🚚 Nomor Resi</h4>
                        <p class="font-mono text-blue-600">${order.tracking_number}</p>
                    </div>
                ` : ''}
            </div>
        `;
        
        document.getElementById('orderDetailContent').innerHTML = content;
        document.getElementById('orderDetailModal').classList.remove('hidden');
        document.getElementById('orderDetailModal').classList.add('flex');
    }
    
    function closeOrderDetail() {
        document.getElementById('orderDetailModal').classList.add('hidden');
        document.getElementById('orderDetailModal').classList.remove('flex');
    }
    
    // Close modal on backdrop click
    document.getElementById('orderDetailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeOrderDetail();
        }
    });
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeOrderDetail();
        }
    });
</script>
@endsection
