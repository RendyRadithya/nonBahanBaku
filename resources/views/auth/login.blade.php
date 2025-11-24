<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center p-4">
        <!-- Header with Logo and Back Button -->
        <div class="absolute top-0 left-0 right-0 p-6">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo MCorder.png') }}" alt="McOrder Logo" class="h-12 w-auto">
                    <div>
                        <div class="font-bold text-lg text-white">McOrder</div>
                        <div class="text-xs text-red-100">McDonald's Citra Garden</div>
                    </div>
                </div>

                <!-- Back Button -->
                <a href="{{ route('welcome') }}" class="bg-white hover:bg-gray-100 text-red-600 px-6 py-2.5 rounded-lg text-sm font-semibold transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Login Card -->
        <div class="w-full max-w-md">
            <div class="bg-white rounded-3xl shadow-2xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang</h1>
                    <p class="text-gray-600 text-sm">Sistem Pemesanan Bahan Baku Non-HAVI</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus 
                                autocomplete="username"
                                placeholder="email@example.com"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            >
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            >
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500"
                            >
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit"
                        class="w-full bg-red-400 hover:bg-red-500 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md hover:shadow-lg"
                    >
                        Login
                    </button>

                    <!-- Register Link -->
                    @if (Route::has('register'))
                        <div class="text-center text-sm text-gray-600">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-red-600 hover:text-red-700 font-semibold">
                                Daftar di sini
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-white text-sm">
                    © 2025 McDonald's Citra Garden - McOrder System
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
