<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - McOrder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-red-600 via-red-700 to-red-800 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-3 mb-4">
                <span class="text-6xl">🍔</span>
            </div>
            <h1 class="text-5xl font-bold text-white mb-2">McOrder</h1>
            <p class="text-white/90 text-lg font-medium">Sistem Pemesanan Non-Bahan Baku</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 border-t-8 border-yellow-400">
            <h2 class="text-3xl font-bold text-neutral-900 mb-2 text-center">Selamat Datang</h2>
            <p class="text-neutral-600 text-center mb-8">Silakan login untuk melanjutkan</p>

            <form action="#" method="POST" class="space-y-6">
                @csrf
                
                <!-- Email/Username Field -->
                <div class="relative">
                    <input 
                        type="text" 
                        id="email" 
                        name="email" 
                        class="peer w-full px-4 py-3 border-2 border-neutral-300 rounded-lg focus:border-red-600 focus:outline-none transition placeholder-transparent"
                        placeholder="Email atau Username"
                        required
                    >
                    <label 
                        for="email" 
                        class="absolute left-4 -top-2.5 bg-white px-2 text-sm font-semibold text-neutral-600 transition-all
                               peer-placeholder-shown:text-base peer-placeholder-shown:text-neutral-400 peer-placeholder-shown:top-3 peer-placeholder-shown:font-normal
                               peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-red-600 peer-focus:font-semibold"
                    >
                        Email atau Username
                    </label>
                </div>

                <!-- Password Field -->
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="peer w-full px-4 py-3 border-2 border-neutral-300 rounded-lg focus:border-red-600 focus:outline-none transition placeholder-transparent"
                        placeholder="Password"
                        required
                    >
                    <label 
                        for="password" 
                        class="absolute left-4 -top-2.5 bg-white px-2 text-sm font-semibold text-neutral-600 transition-all
                               peer-placeholder-shown:text-base peer-placeholder-shown:text-neutral-400 peer-placeholder-shown:top-3 peer-placeholder-shown:font-normal
                               peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-red-600 peer-focus:font-semibold"
                    >
                        Password
                    </label>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-red-600 border-neutral-300 rounded focus:ring-red-500">
                        <span class="text-sm text-neutral-600 font-medium">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-sm text-red-600 hover:text-red-700 font-semibold hover:underline">Lupa Password?</a>
                </div>

                <!-- Login Button (Moved from home.blade.php) -->
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-yellow-400 px-7 py-3.5 text-base font-bold text-neutral-900 hover:bg-yellow-500 transition shadow-lg">
                    <span>🚀</span>
                    Login
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-neutral-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-neutral-500 font-medium">atau</span>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center">
                <a href="/" class="inline-flex items-center gap-2 text-neutral-600 hover:text-red-600 font-semibold transition">
                    <span>←</span>
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-white/80 text-sm">
                © 2024 McOrder - McDonald's Citra Garden
            </p>
        </div>
    </div>
</body>
</html>
