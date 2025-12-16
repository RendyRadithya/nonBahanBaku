<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-6">
        <!-- Page Header -->
        <div class="flex items-start justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900">Laporan & Grafik</h1>
                <p class="text-sm text-neutral-600 mt-1">Analisis pengeluaran dan performa pesanan</p>
            </div>

            <!-- Filter -->
            <form method="GET" action="{{ route('reports') }}" class="flex items-center gap-3">
                <select name="year" onchange="this.form.submit()" class="pl-4 pr-10 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent appearance-none bg-white bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg%20xmlns%3d%22http%3a%2f%2fwww.w3.org%2f2000%2fsvg%22%20fill%3d%22none%22%20viewBox%3d%220%200%2024%2024%22%20stroke%3d%22%23666%22%3e%3cpath%20stroke-linecap%3d%22round%22%20stroke-linejoin%3d%22round%22%20stroke-width%3d%222%22%20d%3d%22M19%209l-7%207-7-7%22%2f%3e%3c%2fsvg%3e')] bg-[length:1.25rem] bg-[right_0.5rem_center] bg-no-repeat">
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
                <select name="month" onchange="this.form.submit()" class="pl-4 pr-10 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent appearance-none bg-white bg-[url('data:image/svg+xml;charset=UTF-8,%3csvg%20xmlns%3d%22http%3a%2f%2fwww.w3.org%2f2000%2fsvg%22%20fill%3d%22none%22%20viewBox%3d%220%200%2024%2024%22%20stroke%3d%22%23666%22%3e%3cpath%20stroke-linecap%3d%22round%22%20stroke-linejoin%3d%22round%22%20stroke-width%3d%222%22%20d%3d%22M19%209l-7%207-7-7%22%2f%3e%3c%2fsvg%3e')] bg-[length:1.25rem] bg-[right_0.5rem_center] bg-no-repeat">
                    <option value="">Semua Bulan</option>
                    @php
                        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    @endphp
                    @foreach($months as $idx => $m)
                        <option value="{{ $idx + 1 }}" {{ $month == ($idx + 1) ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </form>
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
                <div class="text-3xl font-bold text-neutral-900">{{ number_format($stats['total_orders']) }}</div>
                <div class="text-xs text-neutral-500 mt-1">Pesanan di periode ini</div>
            </div>

            <!-- Total Pengeluaran -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Total Pengeluaran</div>
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-neutral-900">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</div>
                <div class="text-xs text-neutral-500 mt-1">Dari pesanan sukses</div>
            </div>

            <!-- Pesanan Selesai -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Pesanan Selesai</div>
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-neutral-900">{{ number_format($stats['completed_orders']) }}</div>
                <div class="text-xs text-neutral-500 mt-1">Berhasil diterima</div>
            </div>

            <!-- Rata-rata Nilai Pesanan -->
            <div class="bg-white p-5 rounded-lg border border-neutral-200 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-sm text-neutral-600">Rata-rata Nilai</div>
                    <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-neutral-900">Rp {{ number_format($stats['avg_order_value'], 0, ',', '.') }}</div>
                <div class="text-xs text-neutral-500 mt-1">Per pesanan</div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Monthly Spending Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
                <h3 class="text-lg font-bold text-neutral-900 mb-4">Pengeluaran Bulanan {{ $year }}</h3>
                <div class="h-64">
                    <canvas id="spendingChart"></canvas>
                </div>
            </div>

            <!-- Monthly Orders Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
                <h3 class="text-lg font-bold text-neutral-900 mb-4">Jumlah Pesanan Bulanan {{ $year }}</h3>
                <div class="h-64">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Distribution & Top Products -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Status Distribution -->
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
                <h3 class="text-lg font-bold text-neutral-900 mb-4">Distribusi Status Pesanan</h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
                <h3 class="text-lg font-bold text-neutral-900 mb-4">Produk Terlaris</h3>
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @forelse($topProducts as $index => $product)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full {{ $index < 3 ? 'bg-red-100 text-red-600' : 'bg-neutral-100 text-neutral-600' }} flex items-center justify-center font-bold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-neutral-900 truncate">{{ $product->product_name }}</p>
                                <p class="text-xs text-neutral-500">{{ number_format($product->total_qty) }} item dipesan</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-neutral-900">Rp {{ number_format($product->total_spent, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-neutral-500 text-center py-8">Belum ada data produk</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Vendors -->
        <div class="bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
            <h3 class="text-lg font-bold text-neutral-900 mb-4">Vendor dengan Pembelian Tertinggi</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-neutral-50 border-b border-neutral-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Peringkat</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Vendor</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Total Pesanan</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Total Pembelian</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200">
                        @php
                            $totalAllVendors = $topVendors->sum('total_spent');
                        @endphp
                        @forelse($topVendors as $index => $vendor)
                            @php
                                $percentage = $totalAllVendors > 0 ? ($vendor->total_spent / $totalAllVendors) * 100 : 0;
                            @endphp
                            <tr class="hover:bg-neutral-50">
                                <td class="px-4 py-3">
                                    <div class="w-8 h-8 rounded-full {{ $index < 3 ? 'bg-yellow-100 text-yellow-700' : 'bg-neutral-100 text-neutral-600' }} flex items-center justify-center font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($vendor->vendor_name, 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-neutral-900">{{ $vendor->vendor_name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-neutral-600">{{ number_format($vendor->total_orders) }} pesanan</td>
                                <td class="px-4 py-3 font-semibold text-neutral-900">Rp {{ number_format($vendor->total_spent, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-2 bg-neutral-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-red-500 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-sm text-neutral-600 w-12 text-right">{{ number_format($percentage, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-neutral-500">Belum ada data vendor</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @push('scripts')
    <script>
        // Data from Laravel
        const monthlySpending = @json($monthlySpending);
        const monthlyOrders = @json($monthlyOrders);
        const statusDistribution = @json($statusDistribution);

        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Spending Chart
        new Chart(document.getElementById('spendingChart'), {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Pengeluaran (Rp)',
                    data: monthlySpending,
                    backgroundColor: 'rgba(220, 38, 38, 0.8)',
                    borderColor: 'rgba(220, 38, 38, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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

        // Orders Chart
        new Chart(document.getElementById('ordersChart'), {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: monthlyOrders,
                    borderColor: 'rgba(147, 51, 234, 1)',
                    backgroundColor: 'rgba(147, 51, 234, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(147, 51, 234, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
        const statusLabels = {
            'pending': 'Menunggu',
            'confirmed': 'Dikonfirmasi',
            'rejected': 'Ditolak',
            'in_progress': 'Diproses',
            'shipped': 'Dikirim',
            'completed': 'Selesai'
        };

        const statusColors = {
            'pending': '#F59E0B',
            'confirmed': '#10B981',
            'rejected': '#EF4444',
            'in_progress': '#3B82F6',
            'shipped': '#8B5CF6',
            'completed': '#059669'
        };

        const statusKeys = Object.keys(statusDistribution);
        const statusData = statusKeys.map(key => statusDistribution[key]);
        const statusLabelsMapped = statusKeys.map(key => statusLabels[key] || key);
        const statusColorsMapped = statusKeys.map(key => statusColors[key] || '#6B7280');

        if (statusKeys.length > 0) {
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: statusLabelsMapped,
                    datasets: [{
                        data: statusData,
                        backgroundColor: statusColorsMapped,
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        } else {
            document.getElementById('statusChart').parentElement.innerHTML = '<p class="text-neutral-500 text-center">Belum ada data status</p>';
        }
    </script>
    @endpush
</x-app-layout>
