<x-app-layout>
    @php
        // fallback jika controller belum mengirim $orders
        $orders = $orders ?? collect();
        $totalOrders = $totalOrders ?? 0;
        $newOrders = $newOrders ?? 0;
        $inProgress = $inProgress ?? 0;
        $completed = $completed ?? 0;
        $totalSales = $totalSales ?? 0;
    @endphp

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Title -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900">Dashboard Vendor</h1>
                <p class="text-sm text-neutral-500">Kelola pesanan dan pengiriman - {{ Auth::user()->store_name ?? Auth::user()->name }}</p>
            </div>
            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-white border border-neutral-200 text-neutral-700 rounded-lg hover:bg-neutral-50 transition shadow-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Manajemen Produk
            </a>
        </div>

        <!-- Stat Cards: equal-width responsive row without horizontal scroll -->
        <div class="mb-8">
            <div class="flex gap-4">
                <!-- card -->
                <div class="flex-1 min-w-0 bg-white rounded-xl p-5 h-44 flex flex-col justify-between transition-transform transform hover:-translate-y-1 hover:shadow-lg duration-200 ease-out">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-xs text-neutral-500">Total Pesanan</div>
                            <div class="text-3xl font-bold text-neutral-900">{{ $totalOrders }}</div>
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
                            <div class="text-3xl font-bold text-blue-600">{{ $newOrders }}</div>
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
                            <div class="text-3xl font-bold text-neutral-900">{{ $inProgress }}</div>
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
                            <div class="text-3xl font-bold text-neutral-900">{{ $completed }}</div>
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
                            <div class="text-3xl font-bold text-red-600">Rp {{ number_format($totalSales,0,',','.') }}</div>
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
                                        if (str_contains($s,'new') || str_contains($s,'pesan') || str_contains($s,'pending')) $badge = 'bg-blue-100 text-blue-700';
                                        if (str_contains($s,'proses') || str_contains($s,'process') || str_contains($s,'progress')) $badge = 'bg-purple-100 text-purple-700';
                                        if (str_contains($s,'kirim') || str_contains($s,'deliv')) $badge = 'bg-orange-100 text-orange-700';
                                        if (str_contains($s,'selesai') || str_contains($s,'complete')) $badge = 'bg-green-100 text-green-700';
                                    @endphp
                                    <span class="inline-block px-3 py-1 rounded-full text-xs {{ $badge }}">{{ $o->status ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <button class="inline-flex items-center justify-center w-9 h-9 border rounded-md text-neutral-600 btn-order-detail" data-id="{{ $o->id }}" title="Lihat Detail">👁</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center py-6 text-neutral-500">Belum ada pesanan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Order Detail Modal for Vendor -->
    <div id="vendor-order-modal" class="fixed inset-0 hidden items-center justify-center z-50" style="background-color: rgba(0,0,0,0.08);">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4">
            <div class="flex items-center justify-between px-5 py-4 border-b">
                <div>
                    <h3 id="vo-title" class="text-lg font-semibold">Detail Pesanan</h3>
                    <div id="vo-sub" class="text-sm text-neutral-500">ORD-xxxx - Informasi Lengkap Pesanan</div>
                </div>
                <button id="vo-close-top" class="text-neutral-500 hover:text-neutral-800">✕</button>
            </div>

            <div class="p-5 space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-xs text-neutral-500">Status Saat Ini:</div>
                        <div id="vo-status-badge" class="inline-block px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-700 mt-1">-</div>
                    </div>
                    <div>
                        <button id="vo-reject" class="px-4 py-2 rounded-lg border text-red-600">Tolak Pesanan</button>
                        <button id="vo-accept" class="px-4 py-2 rounded-lg bg-green-600 text-white ml-3">Terima Pesanan</button>
                    </div>
                </div>

                <div class="border rounded-lg p-4 bg-neutral-50">
                    <h4 class="font-semibold mb-2">Informasi Pesanan</h4>
                    <div class="grid grid-cols-2 gap-2 text-sm text-neutral-700">
                        <div>No. Pesanan</div><div class="text-right font-medium" id="vo-order-number">-</div>
                        <div>Tanggal Pesan</div><div class="text-right" id="vo-order-date">-</div>
                        <div>Produk</div><div class="text-right" id="vo-product">-</div>
                        <div>Jumlah</div><div class="text-right" id="vo-qty">-</div>
                        <div>Tanggal Pengiriman</div><div class="text-right" id="vo-estimated">-</div>
                        <div>Total Harga</div><div class="text-right font-medium text-red-600" id="vo-total">-</div>
                        <div>Catatan dari Store</div><div class="text-right text-neutral-600" id="vo-notes">-</div>
                    </div>
                </div>

                <div class="border rounded-lg p-4 bg-white">
                    <h4 class="font-semibold mb-2">Informasi Pengiriman</h4>
                    <div id="vo-store-info" class="text-sm text-neutral-700">
                        <!-- store/vendor info inserted here -->
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button id="vo-close" class="px-4 py-2 rounded-lg border">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor order modal logic -->
        @push('scripts')
    <script>
        (function(){
            const tableBody = document.querySelector('table tbody');
            const modal = document.getElementById('vendor-order-modal');
            const closeTop = document.getElementById('vo-close-top');
            const closeBtn = document.getElementById('vo-close');
            const acceptBtn = document.getElementById('vo-accept');
            const rejectBtn = document.getElementById('vo-reject');
            let currentOrderId = null;

            // Real-time listener
            if(window.Echo){
                window.Echo.channel('vendor.{{ Auth::id() }}')
                    .listen('.order.created', (e) => {
                        console.log('New Order Received:', e.order);
                        
                        // Play sound
                        const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
                        audio.play().catch(e=>console.log(e));

                        // Show toast/alert
                        const toast = document.createElement('div');
                        toast.className = 'fixed top-4 right-4 bg-blue-600 text-white px-6 py-4 rounded-lg shadow-xl z-50 animate-bounce cursor-pointer';
                        toast.innerHTML = `
                            <div class="font-bold text-lg">Pesanan Baru!</div>
                            <div>${e.order.product_name} (${e.order.quantity} unit)</div>
                            <div class="text-xs mt-1">Klik untuk refresh</div>
                        `;
                        toast.onclick = () => location.reload();
                        document.body.appendChild(toast);
                        setTimeout(() => toast.remove(), 5000);

                        // Update Stats (Simple increment)
                        const totalEl = document.querySelector('.text-3xl.font-bold.text-neutral-900'); // First one is Total
                        if(totalEl) totalEl.textContent = parseInt(totalEl.textContent) + 1;
                        
                        const newEl = document.querySelector('.text-3xl.font-bold.text-blue-600'); // New Orders
                        if(newEl) newEl.textContent = parseInt(newEl.textContent) + 1;

                        // Prepend to table
                        if(tableBody){
                            const row = document.createElement('tr');
                            row.className = 'border-t bg-blue-50 transition-colors duration-1000';
                            row.innerHTML = `
                                <td class="py-3 px-4 font-bold text-blue-700">${e.order.order_number}</td>
                                <td class="py-3 px-4">${new Date().toLocaleDateString('id-ID')}</td>
                                <td class="py-3 px-4">${e.order.vendor_name || '-'}</td>
                                <td class="py-3 px-4">${e.order.product_name}</td>
                                <td class="py-3 px-4">${e.order.quantity}</td>
                                <td class="py-3 px-4">Rp ${Number(e.order.total_price).toLocaleString('id-ID')}</td>
                                <td class="py-3 px-4"><span class="inline-block px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-700">pending</span></td>
                                <td class="py-3 px-4">
                                    <button class="inline-flex items-center justify-center w-9 h-9 border rounded-md text-neutral-600 btn-order-detail" data-id="${e.order.id}" title="Lihat Detail">👁</button>
                                </td>
                            `;
                            // If empty row exists, remove it
                            if(tableBody.children[0] && tableBody.children[0].textContent.includes('Belum ada pesanan')) tableBody.innerHTML = '';
                            tableBody.insertBefore(row, tableBody.firstChild);
                            
                            // Highlight effect
                            setTimeout(() => row.classList.remove('bg-blue-50'), 3000);
                        }
                    });
            }

            function openModal(){ modal.classList.remove('hidden'); modal.classList.add('flex'); }
            function closeModal(){ modal.classList.add('hidden'); modal.classList.remove('flex'); }

            async function loadOrder(id){
                try{
                    const res = await fetch('/orders/' + id + '/tracking');
                    if(!res.ok) throw new Error('Gagal memuat pesanan');
                    const body = await res.json();
                    const o = body.order;
                    currentOrderId = o.id;
                    document.getElementById('vo-order-number').textContent = o.order_number || '-';
                    document.getElementById('vo-order-date').textContent = new Date(o.created_at).toLocaleDateString('id-ID');
                    document.getElementById('vo-product').textContent = o.product_name || '-';
                    document.getElementById('vo-qty').textContent = (o.quantity || '-') + ' unit';
                    document.getElementById('vo-estimated').textContent = o.estimated_delivery ? new Date(o.estimated_delivery).toLocaleDateString('id-ID') : '-';
                    document.getElementById('vo-total').textContent = (function(v){ return 'Rp ' + Number(v||0).toLocaleString('id-ID'); })(o.total_price);
                    document.getElementById('vo-notes').textContent = o.notes || '-';
                    // status badge
                    document.getElementById('vo-status-badge').textContent = body.status_label || (o.status||'-');
                    // vendor/store info (buyer)
                    const storeEl = document.getElementById('vo-store-info');
                    storeEl.innerHTML = '';
                    if(body.vendor){
                        storeEl.innerHTML = `<div class="font-medium">${body.vendor.store_name || body.vendor.name}</div><div class="text-xs text-neutral-500 mt-1">${body.vendor.email || ''}</div><div class="text-xs mt-1">${body.vendor.phone || ''}</div>`;
                    } else {
                        storeEl.innerHTML = `<div class="font-medium">${o.vendor_name || '-'}</div>`;
                    }
                    openModal();
                }catch(err){ console.error(err); alert('Gagal memuat detail pesanan'); }
            }

            // delegate clicks on table for buttons
            const table = document.querySelector('table');
            if(table) {
                table.addEventListener('click', function(e){
                    const btn = e.target.closest('.btn-order-detail');
                    if(!btn) return;
                    const id = btn.dataset.id;
                    if(!id) return;
                    loadOrder(id);
                });
            }

            if(closeTop) closeTop.addEventListener('click', closeModal);
            if(closeBtn) closeBtn.addEventListener('click', closeModal);

            // accept/reject actions
            async function postAction(path, payload){
                try{
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const res = await fetch(path, { method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN': token, 'Accept':'application/json'}, body: JSON.stringify(payload||{}) });
                    return await res.json();
                }catch(err){ console.error(err); return { success: false, message: 'Terjadi kesalahan' }; }
            }

            if(acceptBtn){
                acceptBtn.addEventListener('click', async function(){
                    if(!currentOrderId) return;
                    if(!confirm('Terima pesanan ini?')) return;
                    const body = await postAction('/orders/' + currentOrderId + '/accept');
                    if(body.success){ alert('Pesanan diterima'); closeModal(); location.reload(); }
                    else alert(body.message || 'Gagal menerima pesanan');
                });
            }

            if(rejectBtn){
                rejectBtn.addEventListener('click', async function(){
                    if(!currentOrderId) return;
                    const reason = prompt('Alasan penolakan (opsional):');
                    if(reason === null) return; // cancel
                    const body = await postAction('/orders/' + currentOrderId + '/reject', { reason });
                    if(body.success){ alert('Pesanan ditolak'); closeModal(); location.reload(); }
                    else alert(body.message || 'Gagal menolak pesanan');
                });
            }
        })();
    </script>
    @endpush
</x-app-layout>
