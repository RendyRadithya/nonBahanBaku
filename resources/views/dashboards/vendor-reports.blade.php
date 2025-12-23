@extends('layouts.app')

@section('title', 'Laporan Penjualan - McOrder')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header + Filters (responsive) -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900">Laporan Penjualan</h1>
                <p class="text-sm text-neutral-500 mt-1">Analisis pengeluaran dan performa pesanan</p>
            </div>

            <!-- Filters (card) -->
            <div class="w-full sm:w-auto">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-6">
                    <form method="GET" action="{{ route('vendor.reports') }}" class="flex flex-wrap items-end gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <div class="relative">
                        <select name="year" class="w-full sm:w-28 pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 appearance-none">
                            @foreach($availableYears as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                    <div class="relative">
                        <select name="month" class="w-full sm:w-40 pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 appearance-none">
                            <option value="">Semua Bulan</option>
                            @php
                                $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            @endphp
                            @foreach($months as $i => $m)
                                <option value="{{ $i + 1 }}" {{ $month == $i + 1 ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="w-full sm:w-auto">
                    <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-medium">
                        Cari
                    </button>
                </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Pesanan</p>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_orders']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">📦</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">💰</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Pesanan Selesai</p>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['completed_orders']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">✅</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Rata-rata per Pesanan</p>
                        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($stats['avg_order_value'], 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">📈</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Monthly Sales Chart -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">💵 Pendapatan Bulanan {{ $year }}</h2>
                <canvas id="salesChart" height="200"></canvas>
            </div>

            <!-- Monthly Orders Chart -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">📦 Jumlah Pesanan Bulanan {{ $year }}</h2>
                <canvas id="ordersChart" height="200"></canvas>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Top Products -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">🏆 Produk Terlaris</h2>
                @if($topProducts->count() > 0)
                    <div class="space-y-3">
                        @foreach($topProducts as $i => $product)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 flex items-center justify-center rounded-full {{ $i < 3 ? 'bg-yellow-500 text-white' : 'bg-gray-300 text-gray-700' }} font-bold text-sm">
                                        {{ $i + 1 }}
                                    </span>
                                    <span class="font-medium text-gray-800">{{ $product->product_name }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm text-gray-500">{{ number_format($product->total_qty) }} unit</span>
                                    <p class="text-sm font-semibold text-green-600">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <span class="text-4xl">📊</span>
                        <p class="mt-2">Belum ada data produk</p>
                    </div>
                @endif
            </div>

            <!-- Order Status Distribution -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">📊 Distribusi Status Pesanan</h2>
                <div class="flex justify-center">
                    <div class="w-64 h-64">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">🏪 Pelanggan Terbaik</h2>
            @if($topCustomers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-max w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Peringkat</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Toko</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Total Pesanan</th>
                                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Total Pembelian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($topCustomers as $i => $customer)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">
                                        <span class="w-8 h-8 flex items-center justify-center rounded-full {{ $i < 3 ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }} font-bold text-sm">
                                            {{ $i + 1 }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $customer->user->store_name ?? $customer->user->name ?? '-' }}</p>
                                            <p class="text-sm text-gray-500">{{ $customer->user->name ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                            {{ number_format($customer->total_orders) }} pesanan
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-green-600">
                                        Rp {{ number_format($customer->total_spent, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <span class="text-4xl">🏪</span>
                    <p class="mt-2">Belum ada data pelanggan</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($monthlySales),
                backgroundColor: 'rgba(34, 197, 94, 0.7)',
                borderColor: 'rgba(34, 197, 94, 1)',
                borderWidth: 1,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                        }
                    }
                }
            }
        }
    });

    // Monthly Orders Chart
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ordersCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Pesanan',
                data: @json($monthlyOrders),
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Status Distribution Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = @json($statusDistribution);
    const statusLabels = {
        'pending': 'Menunggu',
        'confirmed': 'Dikonfirmasi',
        'rejected': 'Ditolak',
        'in_progress': 'Diproses',
        'shipped': 'Dikirim',
        'completed': 'Selesai'
    };
    const statusColors = {
        'pending': '#f59e0b',
        'confirmed': '#3b82f6',
        'rejected': '#ef4444',
        'in_progress': '#8b5cf6',
        'shipped': '#06b6d4',
        'completed': '#22c55e'
    };
    
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData).map(key => statusLabels[key] || key),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: Object.keys(statusData).map(key => statusColors[key] || '#9ca3af'),
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15
                    }
                }
            }
        }
    });
</script>
@endsection
