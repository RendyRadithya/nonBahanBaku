<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="relative p-2 text-neutral-600 hover:text-neutral-900 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-600 rounded-full border border-white"></span>
        @endif
    </button>

    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-neutral-100 z-50 py-2" style="display: none;">
        <div class="px-4 py-2 border-b border-neutral-100 flex justify-between items-center">
            <h3 class="font-semibold text-sm">Notifikasi</h3>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <button class="text-xs text-red-600 hover:text-red-700">Tandai semua dibaca</button>
            @endif
        </div>
        <div class="max-h-64 overflow-y-auto">
            @forelse(auth()->user()->notifications as $notification)
                <div class="px-4 py-3 hover:bg-neutral-50 border-b border-neutral-50 last:border-0 {{ $notification->read_at ? 'opacity-60' : '' }}">
                    <div class="text-sm font-medium text-neutral-900">{{ $notification->data['message'] ?? 'Notifikasi Baru' }}</div>
                    <div class="text-xs text-neutral-500 mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <div class="px-4 py-6 text-center text-sm text-neutral-500">
                    Tidak ada notifikasi
                </div>
            @endforelse
        </div>
    </div>
</div>
