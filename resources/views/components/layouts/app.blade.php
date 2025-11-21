<!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{ $title ?? 'McOrder' }}</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
		@vite(['resources/css/app.css','resources/js/app.js'])
	</head>
	<body class="font-sans antialiased bg-white text-neutral-900">
		<header class="sticky top-0 z-30 bg-white border-b border-neutral-200 shadow-sm">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
				<div class="flex h-20 items-center justify-between">
					<a href="{{ url('/') }}" class="flex items-center gap-3">
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
							<div class="flex items-center gap-2">
								<span class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-yellow-400 text-red-600 font-bold text-lg">M</span>
								<div class="flex flex-col">
									<span class="text-lg font-bold text-neutral-900">McOrder</span>
									<span class="text-xs text-neutral-500 -mt-1">McDonald's Citra Garden</span>
								</div>
							</div>
						@endif
					</a>
					<nav class="hidden md:flex items-center gap-8">
						<a href="#tentang" class="text-sm font-medium text-neutral-600 hover:text-neutral-900 transition">Tentang Kami</a>
						<a href="#fitur" class="text-sm font-medium text-neutral-600 hover:text-neutral-900 transition">Fitur</a>
						<a href="#kontak" class="text-sm font-medium text-neutral-600 hover:text-neutral-900 transition">Kontak</a>
					</nav>
					<div class="flex items-center gap-3">
						<a href="/login" class="inline-flex items-center gap-2 rounded-md bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700 transition">
							<span>🔐</span>
							Login
						</a>
					</div>
				</div>
			</div>
		</header>
		<main>
			{{ $slot }}
		</main>
		<footer id="kontak" class="bg-white border-t border-neutral-200 mt-20">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
				<div class="grid gap-10 md:grid-cols-4 mb-12">
					<div class="md:col-span-1">
						@php
							$logoFound = false;
							foreach ($logoPaths as $path) {
								if (file_exists(public_path($path))) {
									$logoFound = $path;
									break;
								}
							}
						@endphp
						@if($logoFound)
							<img src="{{ asset($logoFound) }}" alt="McOrder" class="h-12 w-auto mb-4">
						@else
							<div class="flex items-center gap-2 mb-4">
								<span class="inline-flex h-12 w-12 items-center justify-center rounded-md bg-yellow-400 text-red-600 font-bold text-xl">M</span>
								<span class="text-2xl font-bold text-red-600">McOrder</span>
							</div>
						@endif
						<p class="text-sm text-neutral-600 leading-relaxed mb-6">Sistem pemesanan bahan baku non-HAVI untuk McDonald's Citra Garden yang efisien dan terintegrasi.</p>
						<div class="flex gap-3">
							<a href="#" class="h-10 w-10 rounded-lg border border-neutral-300 flex items-center justify-center text-neutral-600 hover:bg-neutral-100 hover:border-neutral-400 transition">f</a>
							<a href="#" class="h-10 w-10 rounded-lg border border-neutral-300 flex items-center justify-center text-neutral-600 hover:bg-neutral-100 hover:border-neutral-400 transition">📷</a>
							<a href="#" class="h-10 w-10 rounded-lg border border-neutral-300 flex items-center justify-center text-neutral-600 hover:bg-neutral-100 hover:border-neutral-400 transition">🐦</a>
							<a href="#" class="h-10 w-10 rounded-lg border border-neutral-300 flex items-center justify-center text-neutral-600 hover:bg-neutral-100 hover:border-neutral-400 transition">▶</a>
						</div>
					</div>
					<div class="text-sm">
						<div class="font-bold text-base text-neutral-900 mb-4">Navigasi Cepat</div>
						<ul class="space-y-3 text-neutral-600">
							<li><a href="#tentang" class="hover:text-neutral-900 transition">Tentang Kami</a></li>
							<li><a href="#fitur" class="hover:text-neutral-900 transition">Fitur</a></li>
							<li><a href="#" class="hover:text-neutral-900 transition">Design System</a></li>
							<li><a href="/login" class="hover:text-neutral-900 transition">Login</a></li>
						</ul>
					</div>
					<div class="text-sm">
						<div class="font-bold text-base text-neutral-900 mb-4">Hubungi Kami</div>
						<ul class="space-y-3 text-neutral-600">
							<li class="flex items-start gap-3">
								<span class="text-red-600 text-lg flex-shrink-0">📍</span>
								<span class="leading-relaxed">Komp. Perum Citra 6, Citra Garden City Blok L3, Tegal Alur, Kalideres, West Jakarta City, Jakarta 11820</span>
							</li>
							<li class="flex items-center gap-3">
								<span class="text-red-600 text-lg flex-shrink-0">📞</span>
								<span>(021) 5439-8888</span>
							</li>
							<li class="flex items-center gap-3">
								<span class="text-red-600 text-lg flex-shrink-0">✉</span>
								<span>mcorder@mcd-citragarden.com</span>
							</li>
						</ul>
					</div>
					<div class="text-sm">
						<div class="font-bold text-base text-neutral-900 mb-4">Link Penting</div>
						<ul class="space-y-3 text-neutral-600">
							<li><a href="#" class="hover:text-neutral-900 transition">McDonald's Indonesia ↗</a></li>
							<li><a href="#" class="hover:text-neutral-900 transition">Dashboard Store</a></li>
							<li><a href="#" class="hover:text-neutral-900 transition">Dashboard Vendor</a></li>
							<li><a href="#" class="hover:text-neutral-900 transition">Dashboard Admin</a></li>
						</ul>
					</div>
				</div>
				<div class="pt-8 border-t border-neutral-200 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-neutral-500">
					<div>© 2025 McDonald's Indonesia. All rights reserved. McOrder System.</div>
					<div class="flex gap-6">
						<a href="#" class="hover:text-neutral-900 transition">Syarat & Ketentuan</a>
						<a href="#" class="hover:text-neutral-900 transition">Kebijakan Privasi</a>
					</div>
				</div>
			</div>
		</footer>
	</body>
</html>
