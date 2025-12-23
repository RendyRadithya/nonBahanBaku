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
        <style>
            /* Ensure a visible blinking animation for the small status dot */
            @keyframes blink-dot {
                0% { opacity: 1; transform: scale(1); }
                50% { opacity: 0.2; transform: scale(0.9); }
                100% { opacity: 1; transform: scale(1); }
            }
            .dot-blink {
                display: inline-block;
                animation: blink-dot 1s ease-in-out infinite;
            }
        </style>
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
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
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
                    <form id="vendor-filters" method="GET" action="{{ route('dashboard') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                        <div class="relative flex-1 min-w-0 w-full">
                            <input type="text" name="q" id="vendor-q" value="{{ request('q') }}" placeholder="Cari pesanan..." class="pl-10 pr-3 py-2 border rounded-md w-full sm:w-64 text-sm" />
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400 pointer-events-none bg-transparent p-0 m-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/></svg>
                            </div>
                        </div>

                        <select name="status" id="vendor-status" class="border rounded-md px-3 py-2 text-sm w-full sm:w-auto">
                            <option value="">Semua Status</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-max w-full text-sm">
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
                                        // Default values
                                        $badgeClass = 'bg-gray-100 text-gray-700';
                                        $label = $o->status ?? '-';

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
                                                $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                $label = 'Menunggu Konfirmasi';
                                                break;
                                            case 'in_progress':
                                                $badgeClass = 'bg-purple-100 text-purple-700';
                                                $label = 'Sedang Diproses';
                                                break;
                                            case 'shipped':
                                                $badgeClass = 'bg-orange-100 text-orange-700';
                                                $label = 'Dikirim';
                                                break;
                                            case 'completed':
                                                $badgeClass = 'bg-green-100 text-green-700';
                                                $label = 'Selesai';
                                                break;
                                            default:
                                                // leave defaults
                                                break;
                                        }
                                    @endphp
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs {{ $badgeClass }}">
                                        @if($s === 'pending')
                                            <span class="inline-block mr-2">
                                                <span class="w-2.5 h-2.5 inline-block rounded-full bg-red-500 dot-blink"></span>
                                            </span>
                                        @endif
                                        {{ $label }}
                                    </span>
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

    <!-- Action Confirm Modal (centered) -->
    <div id="action-confirm-modal" class="fixed inset-0 hidden items-center justify-center" style="background-color: rgba(0,0,0,0.5); z-index: 99999">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4" style="position:relative; z-index:100000">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-2">Konfirmasi</h3>
                <p id="action-confirm-message" class="text-sm text-neutral-600 mb-6">Apakah Anda yakin?</p>
                <div class="flex justify-end gap-3">
                    <button id="action-confirm-no" class="px-4 py-2 rounded-lg border font-medium">Tidak</button>
                    <button id="action-confirm-yes" class="px-4 py-2 rounded-lg bg-red-600 text-white font-medium">Ya</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Confirmation Modal (with reason) -->
    <div id="reject-modal" class="fixed inset-0 hidden items-center justify-center" style="background-color: rgba(0,0,0,0.5); z-index: 100001">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4" style="position:relative; z-index:100002">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-2">Tolak Pesanan</h3>
                <p id="reject-message" class="text-sm text-neutral-600 mb-4">Anda yakin ingin menolak pesanan <span id="reject-order-number">-</span>? Tindakan ini tidak dapat dibatalkan.</p>

                <label class="block text-sm font-medium text-neutral-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                <textarea id="reject-reason" class="w-full border border-neutral-200 rounded-md p-3 mb-4" rows="3" placeholder="Jelaskan alasan penolakan pesanan..."></textarea>

                <div class="flex justify-end gap-3">
                    <button id="reject-cancel" class="px-4 py-2 rounded-lg border">Batal</button>
                    <button id="reject-confirm" class="px-4 py-2 rounded-lg bg-red-500 text-white">Ya, Tolak Pesanan</button>
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
            let currentStatus = null;

            // Helper: set textContent only if element exists (avoid throwing when element missing)
            function setTextIfExists(idOrEl, text){
                try{
                    const el = (typeof idOrEl === 'string') ? document.getElementById(idOrEl) : idOrEl;
                    if(!el){
                        console.warn('[vendor] missing element for setTextIfExists', idOrEl, text);
                        return false;
                    }
                    el.textContent = text;
                    return true;
                }catch(err){
                    console.error('[vendor] setTextIfExists error', idOrEl, err);
                    return false;
                }
            }

            function setInnerHTMLIfExists(idOrEl, html){
                try{
                    const el = (typeof idOrEl === 'string') ? document.getElementById(idOrEl) : idOrEl;
                    if(!el){
                        console.warn('[vendor] missing element for setInnerHTMLIfExists', idOrEl);
                        return false;
                    }
                    el.innerHTML = html;
                    return true;
                }catch(err){
                    console.error('[vendor] setInnerHTMLIfExists error', idOrEl, err);
                    return false;
                }
            }

            // Lightweight non-blocking toast so we don't interrupt debugging flow with alerts
            function showToast(message, opts = {}){
                try{
                    const t = document.createElement('div');
                    t.className = 'fixed top-6 right-6 bg-black text-white px-4 py-3 rounded shadow-lg z-50 max-w-sm text-sm';
                    t.style.opacity = '0.98';
                    t.textContent = message;
                    document.body.appendChild(t);
                    setTimeout(()=>{ t.remove(); }, opts.duration || 4000);
                    return t;
                }catch(err){ console.error('[vendor] showToast error', err); }
            }

            // Real-time listener (keep existing if working, otherwise ignore for now)
            if(window.Echo){
                window.Echo.channel('vendor.{{ Auth::id() }}')
                    .listen('.order.created', (e) => {
                        console.log('New Order Received:', e.order);
                        // ... (keep existing toast logic) ...
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
                    });
            }

            function openModal(){ modal.classList.remove('hidden'); modal.classList.add('flex'); }
            function closeModal(){ modal.classList.add('hidden'); modal.classList.remove('flex'); }

            async function loadOrder(id){
                try{
                        const res = await fetch('/orders/' + id + '/tracking');
                        let body;
                        if(!res.ok){
                            try{
                                body = await res.json();
                            }catch(e){
                                console.error('Non-JSON error response while loading order', e);
                                throw new Error('Gagal memuat pesanan (server error)');
                            }
                            console.error('Server returned error when loading order:', body);
                            throw new Error(body.message || 'Gagal memuat pesanan: ' + (body.error || 'unknown'));
                        }
                        body = await res.json();
                    const o = body.order;
                    currentOrderId = o.id;
                    currentStatus = o.status;

                    setTextIfExists('vo-order-number', o.order_number || '-');
                    // update modal sub header to show the actual order number instead of placeholder
                    setTextIfExists('vo-sub', (o.order_number || 'ORD-xxxx') + ' - Informasi Lengkap Pesanan');
                    setTextIfExists('vo-order-date', new Date(o.created_at).toLocaleDateString('id-ID'));
                    setTextIfExists('vo-product', o.product_name || '-');
                    setTextIfExists('vo-qty', (o.quantity || '-') + ' unit');
                    setTextIfExists('vo-estimated', o.estimated_delivery ? new Date(o.estimated_delivery).toLocaleDateString('id-ID') : '-');
                    setTextIfExists('vo-total', (function(v){ return 'Rp ' + Number(v||0).toLocaleString('id-ID'); })(o.total_price));
                    setTextIfExists('vo-notes', o.notes || '-');
                    
                    // status badge
                    setTextIfExists('vo-status-badge', body.status_label || (o.status||'-'));
                    
                    // Update buttons based on status
                    updateModalButtons(o.status);

                    // vendor/store info (buyer)
                    if(body.vendor){
                        setInnerHTMLIfExists('vo-store-info', `<div class="font-medium">Pemesanan via: ${body.vendor.store_name || body.vendor.name}</div>`);
                    } else {
                        // clear if present
                        setInnerHTMLIfExists('vo-store-info', '');
                    }
                    
                    openModal();
                }catch(err){
                    console.error('Load order error:', err);
                    showToast('Gagal memuat detail pesanan: ' + (err.message || err));
                    currentOrderId = null;
                }
            }

            function updateModalButtons(status){
                const actionContainer = document.querySelector('#vendor-order-modal .flex.items-center.justify-end.gap-3');
                // Clear existing custom buttons (keep Close)
                // Actually the buttons are in a different div in the HTML: 
                // <div class="flex items-start justify-between"> ... buttons ... </div>
                
                // Find the button container in the top section. Guard against missing #vo-accept.
                let btnContainer = null;
                const acceptEl = document.getElementById('vo-accept');
                if(acceptEl && acceptEl.parentElement){
                    btnContainer = acceptEl.parentElement;
                } else {
                    // fallback: select the top section that contains action buttons
                    btnContainer = document.querySelector('#vendor-order-modal .flex.items-start.justify-between');
                }
                if(!btnContainer){ console.warn('Button container not found for order modal'); return; }
                btnContainer.innerHTML = ''; // Clear

                if(status === 'pending'){
                    btnContainer.innerHTML = `
                        <button id="vo-reject" class="px-4 py-2 rounded-lg border text-red-600 hover:bg-red-50">Tolak</button>
                        <button id="vo-accept" class="px-4 py-2 rounded-lg bg-blue-600 text-white ml-3 hover:bg-blue-700">Terima Pesanan</button>
                    `;
                } else if(status === 'confirmed'){
                    btnContainer.innerHTML = `
                        <button id="vo-process" class="px-4 py-2 rounded-lg bg-purple-600 text-white ml-3 hover:bg-purple-700">Proses Pesanan</button>
                    `;
                } else if(status === 'in_progress'){
                    btnContainer.innerHTML = `
                        <button id="vo-ship" class="px-4 py-2 rounded-lg bg-indigo-600 text-white ml-3 hover:bg-indigo-700">Kirim Pesanan</button>
                    `;
                } else {
                    btnContainer.innerHTML = `<span class="text-sm text-neutral-500 italic">Tidak ada aksi tersedia</span>`;
                }

                // Re-attach listeners
                const newAccept = document.getElementById('vo-accept');
                const newReject = document.getElementById('vo-reject');
                const newProcess = document.getElementById('vo-process');
                const newShip = document.getElementById('vo-ship');

                if(newAccept) newAccept.onclick = () => updateStatus('confirmed');
                if(newReject) newReject.onclick = () => showRejectDialog();
                if(newProcess) newProcess.onclick = () => updateStatus('in_progress');
                if(newShip) newShip.onclick = () => updateStatus('shipped');
            }

            // delegate pointerdown for order detail buttons so the handler fires promptly
            document.addEventListener('pointerdown', function(e){
                const btn = e.target.closest('.btn-order-detail');
                if(!btn) return;
                const id = btn.dataset.id;
                console.log('[vendor] order-detail click', { id });
                if(!id) return;
                // prevent default to avoid focus issues on some browsers
                e.preventDefault();
                loadOrder(id);
            }, { passive: false });

            if(closeTop) closeTop.addEventListener('click', closeModal);
            if(closeBtn) closeBtn.addEventListener('click', closeModal);

            // Centered confirmation dialog helper
            function showConfirmDialog(message, onYes, onNo){
                const cm = document.getElementById('action-confirm-modal');
                const msgEl = document.getElementById('action-confirm-message');
                const yesBtn = document.getElementById('action-confirm-yes');
                const noBtn = document.getElementById('action-confirm-no');
                if(!cm || !msgEl || !yesBtn || !noBtn){ if(typeof onNo === 'function') onNo(); return; }
                msgEl.textContent = message;
                cm.classList.remove('hidden'); cm.classList.add('flex');

                function cleanup(){
                    cm.classList.add('hidden'); cm.classList.remove('flex');
                    yesBtn.removeEventListener('click', yesHandler);
                    noBtn.removeEventListener('click', noHandler);
                }

                function yesHandler(){ cleanup(); if(typeof onYes === 'function') onYes(); }
                function noHandler(){ cleanup(); if(typeof onNo === 'function') onNo(); }

                yesBtn.addEventListener('click', yesHandler);
                noBtn.addEventListener('click', noHandler);
            }

            // Update Status Action (uses centered confirm dialog)
            async function updateStatus(status){
                if(!currentOrderId) return;

                // friendly message for actions
                let msg = 'Ubah status pesanan menjadi ' + status + '?';
                if(status === 'confirmed') msg = 'Apakah Anda yakin untuk terima pesanan?';
                if(status === 'rejected') msg = 'apakah Anda yakin untuk tolak pesanan ?';

                showConfirmDialog(msg, async () => {
                    try{
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const res = await fetch('/vendor/orders/' + currentOrderId + '/status', { 
                            method: 'PATCH', 
                            headers: {
                                'Content-Type':'application/json',
                                'X-CSRF-TOKEN': token, 
                                'Accept':'application/json'
                            }, 
                            body: JSON.stringify({ status: status }) 
                        });
                        const body = await res.json();
                        
                        if(body.success){ 
                            showToast(body.message || 'Status berhasil diperbarui'); 
                            closeModal(); 
                            location.reload(); 
                        } else { 
                            showToast(body.message || 'Gagal memperbarui status'); 
                        }
                    }catch(err){ 
                        console.error(err); 
                        showToast('Terjadi kesalahan saat menghubungi server'); 
                    }
                }, () => {
                    // user cancelled - nothing to do
                });
            }

            // Show Reject Dialog: populate order number and open modal
            function showRejectDialog(){
                const rm = document.getElementById('reject-modal');
                const orderNumEl = document.getElementById('reject-order-number');
                const reasonEl = document.getElementById('reject-reason');
                if(!rm || !orderNumEl || !reasonEl) return;
                // guard reading vo-order-number
                const voNumEl = document.getElementById('vo-order-number');
                orderNumEl.textContent = voNumEl ? voNumEl.textContent || '-' : '-';
                reasonEl.value = '';
                rm.classList.remove('hidden'); rm.classList.add('flex');

                // wire buttons (ensure no duplicate handlers)
                const cancelBtn = document.getElementById('reject-cancel');
                const confirmBtn = document.getElementById('reject-confirm');

                function cleanup(){
                    rm.classList.add('hidden'); rm.classList.remove('flex');
                    cancelBtn.removeEventListener('click', cancelHandler);
                    confirmBtn.removeEventListener('click', confirmHandler);
                }

                function cancelHandler(){ cleanup(); }

                async function confirmHandler(){
                    const reason = reasonEl.value.trim();
                    if(!reason){ showToast('Alasan penolakan wajib diisi'); reasonEl.focus(); return; }
                    // disable button to prevent double submit
                    confirmBtn.disabled = true; confirmBtn.classList.add('opacity-60', 'cursor-not-allowed');
                    try{
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const res = await fetch('/vendor/orders/' + currentOrderId + '/status', {
                            method: 'PATCH',
                            headers: {
                                'Content-Type':'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept':'application/json'
                            },
                            body: JSON.stringify({ status: 'rejected', reason: reason })
                        });
                        const body = await res.json();
                        if(body.success){
                            showToast(body.message || 'Pesanan ditolak');
                            cleanup();
                            closeModal();
                            location.reload();
                        } else {
                            showToast(body.message || 'Gagal menolak pesanan');
                            confirmBtn.disabled = false; confirmBtn.classList.remove('opacity-60', 'cursor-not-allowed');
                        }
                    }catch(err){
                        console.error(err);
                        showToast('Terjadi kesalahan saat menghubungi server');
                        confirmBtn.disabled = false; confirmBtn.classList.remove('opacity-60', 'cursor-not-allowed');
                    }
                }

                cancelBtn.addEventListener('click', cancelHandler);
                confirmBtn.addEventListener('click', confirmHandler);
            }
        })();
    </script>
    @endpush
    @push('scripts')
    <script>
        (function(){
            const form = document.getElementById('vendor-filters');
            const qInput = document.getElementById('vendor-q');
            const status = document.getElementById('vendor-status');
            // submit when status changes
            if(status){ status.addEventListener('change', ()=> form.submit()); }

            // debounce for typing
            let t;
            if(qInput){
                qInput.addEventListener('input', function(e){
                    clearTimeout(t);
                    t = setTimeout(()=> form.submit(), 500);
                });
                // allow Enter to submit immediately
                qInput.addEventListener('keydown', function(e){ if(e.key === 'Enter'){ e.preventDefault(); form.submit(); } });
            }
        })();
    </script>
    @endpush
</x-app-layout>
