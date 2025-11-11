<x-layouts.app :title="'Beranda - McOrder'">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-red-600">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 lg:py-32">
            <div class="grid gap-12 lg:grid-cols-2 items-center">
                <div class="text-white">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/20 px-4 py-2 mb-6 backdrop-blur-sm border border-white/30">
                        <span class="text-lg">🛒</span>
                        <span class="text-sm font-medium text-white">Sistem Pemesanan Digital</span>
                    </div>
                    <h1 class="text-6xl sm:text-7xl lg:text-8xl font-bold leading-tight mb-6 text-white">
                        McOrder
                    </h1>
                    <p class="text-lg sm:text-xl mb-4 text-white font-semibold">
                        Solusi Digital Pemesanan Non-Bahan Baku<br>untuk McDonald's Citra Garden
                    </p>
                    <p class="text-base sm:text-lg mb-10 text-white/90 leading-relaxed">
                        Efisiensi pemesanan Gas, CO₂, Translite, dan Akrilik dalam satu platform terintegrasi.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#mulai" class="inline-flex items-center gap-2 rounded-lg bg-yellow-400 px-7 py-3.5 text-base font-bold text-neutral-900 hover:bg-yellow-500 transition shadow-lg">
                            <span>🚀</span>
                            Mulai Sekarang
                        </a>
                        <a href="#tentang" class="inline-flex items-center gap-2 rounded-lg bg-transparent border-2 border-white px-7 py-3.5 text-base font-semibold text-white hover:bg-white/10 transition">
                            Pelajari Lebih Lanjut
                            <span>→</span>
                        </a>
                    </div>
                </div>
                <div class="relative lg:mt-0 mt-8">
                    @php
                        $imagePaths = [
                            'images/Mcdonald Citra Garden.jpg',
                            'images/Mcdonald Citra Garden.jpeg',
                            'images/mcd-store.jpg',
                            'images/mcd-store.jpeg',
                        ];
                        $imageFound = false;
                        foreach ($imagePaths as $path) {
                            if (file_exists(public_path($path))) {
                                $imageFound = $path;
                                break;
                            }
                        }
                    @endphp
                    @if($imageFound)
                        <div class="rounded-2xl overflow-hidden border-8 border-white/30 shadow-2xl mb-8 bg-white/10">
                            <img src="{{ asset($imageFound) }}" alt="McDonald's Citra Garden" class="w-full h-[450px] lg:h-[500px] object-cover object-center">
                        </div>
                        <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                            <div class="bg-white rounded-lg px-6 py-4 min-w-[150px] shadow-lg text-center hover:shadow-xl transition">
                                <div class="text-3xl font-bold text-red-600 mb-2">4</div>
                                <div class="text-sm text-neutral-600 font-semibold">Vendor</div>
                            </div>
                            <div class="bg-white rounded-lg px-6 py-4 min-w-[150px] shadow-lg text-center hover:shadow-xl transition">
                                <div class="text-3xl font-bold text-red-600 mb-2">24/7</div>
                                <div class="text-sm text-neutral-600 font-semibold">Akses</div>
                            </div>
                            <div class="bg-white rounded-lg px-6 py-4 min-w-[150px] shadow-lg text-center hover:shadow-xl transition">
                                <div class="text-3xl font-bold text-red-600 mb-2">100%</div>
                                <div class="text-sm text-neutral-600 font-semibold">Digital</div>
                            </div>
                        </div>
                    @else
                        <div class="rounded-2xl border-8 border-white/30 bg-red-700/50 aspect-[4/3] grid place-items-center mb-8">
                            <div class="text-white text-center">
                                <div class="text-5xl mb-3">🍔</div>
                                <p class="text-sm font-medium">Gambar restoran McDonald's</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                            <div class="bg-white rounded-lg px-6 py-4 min-w-[150px] shadow-lg text-center">
                                <div class="text-3xl font-bold text-red-600 mb-2">4</div>
                                <div class="text-sm text-neutral-600 font-semibold">Vendor</div>
                            </div>
                            <div class="bg-white rounded-lg px-6 py-4 min-w-[150px] shadow-lg text-center">
                                <div class="text-3xl font-bold text-red-600 mb-2">24/7</div>
                                <div class="text-sm text-neutral-600 font-semibold">Akses</div>
                            </div>
                            <div class="bg-white rounded-lg px-6 py-4 min-w-[150px] shadow-lg text-center">
                                <div class="text-3xl font-bold text-red-600 mb-2">100%</div>
                                <div class="text-sm text-neutral-600 font-semibold">Digital</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang" class="bg-white py-20 border-t-8 border-red-600">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="inline-flex items-center gap-2 rounded-full bg-red-100 px-4 py-2 mb-8">
                        <span class="text-sm font-bold text-red-700">Tentang Kami</span>
                    </div>
                    <h2 class="text-5xl sm:text-6xl font-bold text-neutral-900 mb-3 leading-tight">
                        Transformasi Digital<br><span class="text-red-600">Pemesanan Bahan Baku</span>
                    </h2>
                    <p class="text-xl font-bold text-neutral-700 mb-8">McDonald's Citra Garden</p>
                    <p class="text-base text-neutral-600 mb-6 leading-relaxed">
                        <strong>McOrder</strong> adalah solusi digital inovatif yang dirancang khusus untuk mengelola pemesanan non-bahan baku. Sebelumnya, proses pemesanan dilakukan secara manual melalui WhatsApp dan email, yang memakan waktu dan rentan terhadap kesalahan.
                    </p>
                    <p class="text-base text-neutral-600 mb-10 leading-relaxed">
                        Sebelumnya, proses pemesanan dilakukan secara manual melalui WhatsApp dan email, yang memakan waktu dan rentan terhadap kesalahan. McOrder menghadirkan platform terintegrasi yang memudahkan koordinasi antara store staff, vendor, dan admin pusat.
                    </p>
                    <div class="space-y-6">
                        <div class="flex gap-4 items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white font-bold text-lg">✓</div>
                            <div>
                                <div class="font-bold text-lg text-neutral-900 mb-1">Efisiensi Operasional</div>
                                <p class="text-sm text-neutral-600 leading-relaxed">Mengurangi waktu pemesanan dari 30 menit menjadi 5 menit</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-lg">🛡</div>
                            <div>
                                <div class="font-bold text-lg text-neutral-900 mb-1">Akurasi Data</div>
                                <p class="text-sm text-neutral-600 leading-relaxed">Minimalisir kesalahan pencatatan dan duplikasi pesanan</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold text-lg">📈</div>
                            <div>
                                <div class="font-bold text-lg text-neutral-900 mb-1">Transparansi Real-time</div>
                                <p class="text-sm text-neutral-600 leading-relaxed">Tracking status pesanan dari pengajuan hingga selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-white rounded-xl border-2 border-red-200 shadow-md p-6 hover:shadow-lg transition">
                        <div class="flex items-start gap-4">
                            <span class="text-red-600 text-3xl flex-shrink-0">📍</span>
                            <div>
                                <div class="font-bold text-lg text-neutral-900 mb-2">Lokasi</div>
                                <div class="text-sm font-semibold text-neutral-700 mb-2">McDonald's Citra Garden</div>
                                <div class="text-xs text-neutral-600 leading-relaxed">Jl. Taman Permata Buana, Pegadungan, Kec. Kalideres, Jakarta Barat</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border-2 border-neutral-200 shadow-md p-6 hover:shadow-lg transition">
                        <div class="font-bold text-lg text-neutral-900 mb-3">Kategori Produk Non-HAVI</div>
                        <div class="text-xs text-neutral-600 mb-4 font-medium">Bahan baku yang dikelola melalui McOrder</div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-lg p-4 text-center hover:shadow-md transition">
                                <div class="text-red-600 text-3xl mb-2">🔥</div>
                                <div class="text-xs font-bold text-neutral-900 mb-1">Gas LPG</div>
                                <div class="text-xs text-neutral-600 font-medium">Sadikun</div>
                            </div>
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-4 text-center hover:shadow-md transition">
                                <div class="text-blue-600 text-2xl font-bold mb-2">CO₂</div>
                                <div class="text-xs font-bold text-neutral-900 mb-1">CO₂</div>
                                <div class="text-xs text-neutral-600 font-medium">Kencana Emas</div>
                            </div>
                            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-lg p-4 text-center hover:shadow-md transition">
                                <div class="text-yellow-600 text-3xl mb-2">📄</div>
                                <div class="text-xs font-bold text-neutral-900 mb-1">Translite</div>
                                <div class="text-xs text-neutral-600 font-medium">Menu Board</div>
                            </div>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-4 text-center hover:shadow-md transition">
                                <div class="text-green-600 text-3xl mb-2">⬜</div>
                                <div class="text-xs font-bold text-neutral-900 mb-1">Akrilik</div>
                                <div class="text-xs text-neutral-600 font-medium">Display</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-xl p-8 text-white text-center shadow-lg hover:shadow-xl transition">
                        <div class="text-7xl font-bold mb-4">3</div>
                        <div class="text-base mb-6 font-semibold">Peran Pengguna Terintegrasi</div>
                        <div class="flex gap-3 justify-center">
                            <span class="bg-red-800 rounded-md px-4 py-2 text-sm font-bold hover:bg-red-900 transition">Store</span>
                            <span class="bg-red-800 rounded-md px-4 py-2 text-sm font-bold hover:bg-red-900 transition">Vendor</span>
                            <span class="bg-red-800 rounded-md px-4 py-2 text-sm font-bold hover:bg-red-900 transition">Admin</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="fitur" class="bg-gray-50 py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <div class="inline-flex items-center gap-2 rounded-full bg-yellow-100 px-4 py-2 mb-6">
                    <span class="text-sm font-bold text-yellow-700">Fitur Unggulan</span>
                </div>
                <h2 class="text-5xl sm:text-6xl font-bold text-neutral-900 mb-6">
                    Fitur-Fitur McOrder
                </h2>
                <p class="text-lg text-neutral-600 max-w-3xl mx-auto leading-relaxed">
                    Platform lengkap untuk mengelola seluruh proses pemesanan bahan baku<br>dengan mudah dan efisien
                </p>
            </div>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 mb-16">
                @php
                    $features = [
                        ['icon' => '🛒', 'color' => 'red', 'title' => 'Pemesanan Cepat', 'desc' => 'Store Staff dapat membuat pesanan dalam hitungan menit', 'points' => ['Form pemesanan sederhana dan intuitif', 'Pilihan vendor otomatis berdasarkan kategori', 'Estimasi harga real-time']],
                        ['icon' => '🔔', 'color' => 'blue', 'title' => 'Notifikasi Real-time', 'desc' => 'Update status pesanan langsung ke semua pihak terkait', 'points' => ['Notifikasi pesanan baru untuk vendor', 'Update status pengiriman ke store', 'Alert untuk admin monitoring']],
                        ['icon' => '⏱', 'color' => 'green', 'title' => 'Tracking Status', 'desc' => 'Pantau pesanan dari pembuatan hingga selesai', 'points' => ['Timeline status yang jelas', 'History pesanan lengkap', 'Filter dan pencarian advanced']],
                        ['icon' => '📦', 'color' => 'yellow', 'title' => 'Manajemen Vendor', 'desc' => 'Dashboard khusus untuk vendor memproses pesanan', 'points' => ['Terima atau tolak pesanan masuk', 'Update status pengiriman', 'Statistik performa vendor']],
                        ['icon' => '⚙', 'color' => 'red', 'title' => 'Admin Dashboard', 'desc' => 'Monitoring dan kontrol penuh untuk admin pusat', 'points' => ['Overview semua transaksi', 'Analytics dan reporting', 'Manajemen user dan vendor']],
                        ['icon' => '📊', 'color' => 'orange', 'title' => 'Laporan & Analitik', 'desc' => 'Data insights untuk decision making yang lebih baik', 'points' => ['Grafik tren pemesanan', 'Laporan pengeluaran bulanan', 'Export data ke Excel/PDF']],
                    ];
                @endphp
                @foreach($features as $feature)
                    <div class="bg-white rounded-2xl border border-neutral-200 shadow-md p-8 hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="flex items-start gap-5 mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-{{ $feature['color'] }}-100 to-{{ $feature['color'] }}-50 flex items-center justify-center text-4xl flex-shrink-0">
                                {{ $feature['icon'] }}
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-xl text-neutral-900 mb-2">{{ $feature['title'] }}</h3>
                                <p class="text-sm text-neutral-600 leading-relaxed">{{ $feature['desc'] }}</p>
                            </div>
                        </div>
                        <ul class="space-y-3">
                            @foreach($feature['points'] as $point)
                                <li class="flex items-start gap-3 text-sm text-neutral-600">
                                    <span class="text-green-500 text-lg flex-shrink-0 mt-0.5">✓</span>
                                    <span class="leading-relaxed">{{ $point }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                @php
                    $highlights = [
                        ['icon' => '🛡', 'color' => 'blue', 'title' => 'Keamanan Data', 'desc' => 'Enkripsi dan proteksi data tingkat tinggi'],
                        ['icon' => '👥', 'color' => 'purple', 'title' => 'Multi-Role Access', 'desc' => '3 peran dengan akses berbeda'],
                        ['icon' => '📱', 'color' => 'green', 'title' => 'Responsive Design', 'desc' => 'Mobile, tablet, desktop ready'],
                        ['icon' => '⚡', 'color' => 'orange', 'title' => 'McDonald\'s UI', 'desc' => 'Sesuai brand guideline resmi'],
                    ];
                @endphp
                @foreach($highlights as $highlight)
                    <div class="bg-white rounded-2xl border border-neutral-200 shadow-md p-6 text-center hover:shadow-lg transition">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-{{ $highlight['color'] }}-100 to-{{ $highlight['color'] }}-50 mx-auto mb-5 flex items-center justify-center text-3xl">
                            {{ $highlight['icon'] }}
                        </div>
                        <h4 class="font-bold text-lg text-neutral-900 mb-2">{{ $highlight['title'] }}</h4>
                        <p class="text-sm text-neutral-600 leading-relaxed">{{ $highlight['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
