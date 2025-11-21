<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - McOrder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-neutral-200 shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    @php
                        $logoPaths = [
                            'images/Logo MCorder.png',
                            'images/Logo MCorder.jpg',
                            'images/logo-mcorder.png',
                            'images/logo-mcorder.jpg',
                        ];
                        $logoFound = false;
                        foreach ($logoPaths as $path) {
                            if (file_exists(public_path($path))) {
                                $logoFound = $path;
                                break;
                            }
                        }
                    @endphp
                    @if($logoFound)
                        <img src="{{ asset($logoFound) }}" alt="McOrder" class="h-10 w-auto">
                    @else
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-yellow-400 text-red-600 font-bold text-lg">M</span>
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-neutral-900">McOrder</span>
                            <span class="text-xs text-neutral-500 -mt-1">McDonald's Citra Garden</span>
                        </div>
                    @endif
                </div>
                
                <!-- User Info & Logout -->
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-sm font-semibold text-neutral-900">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-neutral-500">Administrator</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition">
                            <span>🚪</span>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <!-- Welcome Card -->
        <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
            <h1 class="text-4xl font-bold text-neutral-900 mb-2">Dashboard Admin ⚙️</h1>
            <p class="text-lg text-neutral-600">Selamat datang, <span class="font-semibold text-red-600">{{ Auth::user()->name }}</span></p>
            <p class="text-sm text-neutral-500 mt-2">Administrator McOrder System</p>
        </div>

        <!-- Info -->
        <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-purple-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="font-semibold text-purple-900 mb-1">Dashboard Admin Segera Hadir</h3>
                    <p class="text-sm text-purple-800">Fitur untuk monitoring dan mengelola seluruh sistem McOrder sedang dalam pengembangan.</p>
                    <p class="text-sm text-purple-700 mt-2">Fitur yang akan tersedia:</p>
                    <ul class="list-disc list-inside text-sm text-purple-700 mt-1 space-y-1">
                        <li>Overview semua pesanan dari semua user</li>
                        <li>Manajemen user dan vendor</li>
                        <li>Laporan dan statistik lengkap</li>
                        <li>Pengaturan sistem</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
