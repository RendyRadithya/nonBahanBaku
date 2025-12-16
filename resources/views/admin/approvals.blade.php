<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan User - Admin McOrder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes slide-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slide-out {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        .animate-slide-in {
            animation: slide-in 0.3s ease-out forwards;
        }
        .animate-slide-out {
            animation: slide-out 0.3s ease-in forwards;
        }
    </style>
</head>
<body class="bg-neutral-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-neutral-200 shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-yellow-400 text-red-600 font-bold text-lg">M</span>
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-neutral-900">McOrder</span>
                            <span class="text-xs text-neutral-500 -mt-1">Admin Panel</span>
                        </div>
                    </a>
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
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-neutral-900">Permintaan Registrasi User</h1>
            <a href="{{ route('dashboard') }}" class="text-sm text-neutral-600 hover:text-neutral-900">← Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div id="success-toast" class="fixed top-6 right-6 z-50 animate-slide-in">
                <div class="bg-white rounded-xl shadow-2xl border border-green-200 p-4 flex items-start gap-4 max-w-md">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-green-800">Berhasil!</h4>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                    <button onclick="closeToast('success-toast')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if(session('rejected'))
            <div id="rejected-toast" class="fixed top-6 right-6 z-50 animate-slide-in">
                <div class="bg-white rounded-xl shadow-2xl border border-red-200 p-4 flex items-start gap-4 max-w-md">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-red-800">User Ditolak!</h4>
                        <p class="text-sm text-red-700">{{ session('rejected') }}</p>
                    </div>
                    <button onclick="closeToast('rejected-toast')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
            @if($pendingUsers->count() > 0)
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Role</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Info Tambahan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Tanggal Daftar</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @foreach($pendingUsers as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-neutral-900">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-neutral-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-neutral-500">
                                        @if($user->store_name)
                                            <div>Store: {{ $user->store_name }}</div>
                                        @endif
                                        @if($user->phone)
                                            <div>Telp: {{ $user->phone }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-neutral-500">{{ $user->created_at->format('d M Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('admin.approve', $user->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-md text-xs font-semibold transition">
                                                Setujui
                                            </button>
                                        </form>
                                        <button type="button" 
                                            onclick="openRejectModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')"
                                            class="text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-md text-xs font-semibold transition">
                                            Tolak
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-neutral-900">Tidak ada permintaan</h3>
                    <p class="mt-1 text-sm text-neutral-500">Semua user telah disetujui.</p>
                </div>
            @endif
        </div>
    </main>

    <!-- Reject Confirmation Modal -->
    <div id="reject-modal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeRejectModal()"></div>
        
        <!-- Modal Content -->
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
                <!-- Header -->
                <div class="p-6 text-center">
                    <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Tolak Registrasi User?</h3>
                    <p class="text-gray-600 text-sm mb-2">Anda akan menolak dan menghapus user:</p>
                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                        <p class="font-semibold text-gray-900" id="reject-user-name">-</p>
                        <p class="text-sm text-gray-500" id="reject-user-email">-</p>
                    </div>
                    <p class="text-red-600 text-sm font-medium">⚠️ Tindakan ini tidak dapat dibatalkan!</p>
                </div>
                
                <!-- Actions -->
                <div class="flex border-t border-gray-200">
                    <button type="button" onclick="closeRejectModal()" class="flex-1 px-6 py-4 text-gray-700 font-semibold hover:bg-gray-50 transition rounded-bl-2xl">
                        Batal
                    </button>
                    <form id="reject-form" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-6 py-4 text-white bg-red-600 hover:bg-red-700 font-semibold transition rounded-br-2xl">
                            Ya, Tolak User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(userId, userName, userEmail) {
            document.getElementById('reject-user-name').textContent = userName;
            document.getElementById('reject-user-email').textContent = userEmail;
            document.getElementById('reject-form').action = '/admin/approvals/' + userId;
            document.getElementById('reject-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRejectModal() {
            document.getElementById('reject-modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.remove('animate-slide-in');
                toast.classList.add('animate-slide-out');
                setTimeout(() => toast.remove(), 300);
            }
        }

        // Auto-hide toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = ['success-toast', 'rejected-toast'];
            toasts.forEach(function(toastId) {
                const toast = document.getElementById(toastId);
                if (toast) {
                    setTimeout(() => closeToast(toastId), 5000);
                }
            });
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRejectModal();
            }
        });
    </script>
</body>
</html>
