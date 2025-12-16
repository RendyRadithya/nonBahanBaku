<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>McOrder</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/Logo MCorder.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/Logo MCorder.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white border-b border-neutral-200 shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3">
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
                <!-- Mulai Sekarang Button -->
                <a href="/" class="inline-flex items-center gap-2 rounded-md bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700 transition">
                    <span>→</span>
                    Mulai Sekarang
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center bg-red-600 px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Register Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <h2 class="text-3xl font-bold text-neutral-900 mb-2 text-center">Daftar Akun Baru</h2>
                <p class="text-neutral-500 text-center mb-8 text-sm">Sistem Pemesanan Bahan Baku Non-HAVI</p>

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">❌</span>
                            <div class="flex-1">
                                <p class="text-red-800 font-semibold mb-2">Terjadi kesalahan:</p>
                                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex items-center justify-between text-xs text-neutral-600 mb-2">
                        <span id="step-label">Langkah 1 dari 3</span>
                        <span id="step-name">Informasi Dasar</span>
                    </div>
                    <div class="w-full bg-neutral-200 rounded-full h-2">
                        <div id="progress-bar" class="bg-red-600 h-2 rounded-full transition-all duration-300" style="width: 33.33%"></div>
                    </div>
                </div>

                <!-- Multi-Step Form -->
                <form id="register-form" action="{{ route('register.post') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Step 1: Informasi Dasar -->
                    <div id="step-1" class="step-content">
                        <!-- Daftar Sebagai: pilihan antara Manager Stock atau Vendor -->
                        <div>
                            <label for="role" class="block text-sm font-semibold text-neutral-700 mb-2">Daftar Sebagai</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <select 
                                    id="role"
                                    name="role"
                                    class="w-full pl-10 pr-4 py-2.5 border border-neutral-300 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none transition appearance-none bg-white"
                                    required
                                >
                                    <option value="manager_stock">Manager Stock</option>
                                    <option value="vendor">Vendor</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Nama Lengkap -->
                        <div>
                            <label for="full_name" class="block text-sm font-semibold text-neutral-700 mb-2">Nama Lengkap</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    id="full_name" 
                                    name="name" 
                                    class="w-full pl-10 pr-4 py-2.5 border border-neutral-300 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none transition"
                                    placeholder="John Doe"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Next Button -->
                        <button type="button" onclick="nextStep(2)" class="w-full rounded-lg bg-red-600 px-7 py-3 text-base font-semibold text-white hover:bg-red-700 transition shadow-md flex items-center justify-center gap-2 mt-6">
                            Lanjut
                            <span>→</span>
                        </button>
                    </div>

                    <!-- Step 2: Kontak -->
                    <div id="step-2" class="step-content hidden">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-neutral-700 mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="w-full pl-10 pr-4 py-2.5 border border-neutral-300 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none transition"
                                    placeholder="Manager@gmail.com"
                                    required
                                >
                            </div>
                        </div>

                        <!-- No. Telepon -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-neutral-700 mb-2">No. Telepon</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    class="w-full pl-10 pr-4 py-2.5 border border-neutral-300 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none transition"
                                    placeholder="08348384348"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Nama Store -->
                        <div>
                            <label id="storeLabel" for="store_name" class="block text-sm font-semibold text-neutral-700 mb-2">Nama Store</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    id="store_name" 
                                    name="store_name" 
                                    class="w-full pl-10 pr-4 py-2.5 border border-neutral-300 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none transition"
                                    placeholder="Mcd"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex gap-3 mt-6">
                            <button type="button" onclick="prevStep(1)" class="flex-1 rounded-lg bg-neutral-200 px-7 py-3 text-base font-semibold text-neutral-700 hover:bg-neutral-300 transition shadow-md flex items-center justify-center gap-2">
                                <span>←</span>
                                Kembali
                            </button>
                            <button type="button" onclick="nextStep(3)" class="flex-1 rounded-lg bg-red-600 px-7 py-3 text-base font-semibold text-white hover:bg-red-700 transition shadow-md flex items-center justify-center gap-2">
                                Lanjut
                                <span>→</span>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Password -->
                    <div id="step-3" class="step-content hidden">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-neutral-700 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="w-full pl-10 pr-12 py-2.5 border border-neutral-300 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none transition"
                                    placeholder="••••••••"
                                    required
                                >
                                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-neutral-400 hover:text-neutral-600">
                                    <svg id="password-eye-open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="password-eye-closed" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-neutral-700 mb-2">Konfirmasi Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    class="w-full pl-10 pr-12 py-2.5 border border-neutral-300 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none transition"
                                    placeholder="••••••••"
                                    required
                                >
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-neutral-400 hover:text-neutral-600">
                                    <svg id="password_confirmation-eye-open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="password_confirmation-eye-closed" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            <!-- Inline Error Message -->
                            <div id="password-error" class="hidden mt-2 flex items-center gap-2 text-red-600 text-sm">
                                <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span id="password-error-text">Password dan Konfirmasi Password tidak sama!</span>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex gap-3 mt-6">
                            <button type="button" onclick="prevStep(2)" class="flex-1 rounded-lg bg-neutral-200 px-7 py-3 text-base font-semibold text-neutral-700 hover:bg-neutral-300 transition shadow-md flex items-center justify-center gap-2">
                                <span>←</span>
                                Kembali
                            </button>
                            <button type="button" onclick="submitForm()" class="flex-1 rounded-lg bg-red-600 px-7 py-3 text-base font-semibold text-white hover:bg-red-700 transition shadow-md">
                                Daftar
                            </button>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center text-sm pt-4">
                        <span class="text-neutral-600">Sudah punya akun?</span>
                        <a href="/login" class="text-red-600 hover:text-red-700 font-semibold hover:underline ml-1">Login di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-red-600 py-4">
        <div class="text-center">
            <p class="text-white text-sm">
                © 2025 McDonald's Citra Garden - McOrder System
            </p>
        </div>
    </footer>

    <script>
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const eyeOpen = document.getElementById(fieldId + '-eye-open');
            const eyeClosed = document.getElementById(fieldId + '-eye-closed');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordField.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        function validateStep(step) {
            let isValid = true;
            const currentStep = document.getElementById('step-' + step);
            
            // Get all required inputs in current step
            const requiredInputs = currentStep.querySelectorAll('input[required], select[required]');
            
            requiredInputs.forEach(input => {
                // Remove previous error styling
                input.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
                
                // Check if input is empty
                if (!input.value.trim()) {
                    isValid = false;
                    // Add error styling
                    input.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                }
            });
            
            // Additional validation for step 3 (password matching)
            if (step === 3) {
                const password = document.getElementById('password');
                const passwordConfirmation = document.getElementById('password_confirmation');
                const passwordError = document.getElementById('password-error');
                const passwordErrorText = document.getElementById('password-error-text');
                
                // Hide error first
                if (passwordError) {
                    passwordError.classList.add('hidden');
                }
                
                if (password.value && passwordConfirmation.value && password.value !== passwordConfirmation.value) {
                    isValid = false;
                    password.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                    passwordConfirmation.classList.add('border-red-500', 'ring-1', 'ring-red-500');
                    // Show inline error message
                    if (passwordError) {
                        passwordErrorText.textContent = 'Password dan Konfirmasi Password tidak sama!';
                        passwordError.classList.remove('hidden');
                    }
                }
            }
            
            return isValid;
        }

        function nextStep(step) {
            // Get current step number
            const currentStepNum = step - 1;
            
            // Validate current step before moving to next
            if (!validateStep(currentStepNum)) {
                // Error styling is already applied by validateStep
                // No need for alert - the red border indicates the error
                return;
            }
            
            // Hide all steps
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            
            // Show target step
            document.getElementById('step-' + step).classList.remove('hidden');
            
            // Update progress bar
            const progress = (step / 3) * 100;
            document.getElementById('progress-bar').style.width = progress + '%';
            
            // Update step label
            document.getElementById('step-label').textContent = 'Langkah ' + step + ' dari 3';
            
            // Update step name
            const stepNames = {
                1: 'Informasi Dasar',
                2: 'Kontak',
                3: 'Password'
            };
            document.getElementById('step-name').textContent = stepNames[step];
            // Ensure store label is correct when moving between steps
            if (typeof window.updateStoreLabel === 'function') {
                window.updateStoreLabel();
            }
        }

        function prevStep(step) {
            // No validation needed when going back
            // Hide all steps
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            
            // Show target step
            document.getElementById('step-' + step).classList.remove('hidden');
            
            // Update progress bar
            const progress = (step / 3) * 100;
            document.getElementById('progress-bar').style.width = progress + '%';
            
            // Update step label
            document.getElementById('step-label').textContent = 'Langkah ' + step + ' dari 3';
            
            // Update step name
            const stepNames = {
                1: 'Informasi Dasar',
                2: 'Kontak',
                3: 'Password'
            };
            document.getElementById('step-name').textContent = stepNames[step];
        }

        // Remove error styling when user starts typing
        document.addEventListener('DOMContentLoaded', function() {
            const allInputs = document.querySelectorAll('input, select');
            allInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
                    // Hide password error message when typing in password fields
                    if (this.id === 'password' || this.id === 'password_confirmation') {
                        const passwordError = document.getElementById('password-error');
                        if (passwordError) {
                            passwordError.classList.add('hidden');
                        }
                    }
                });
            });

            // Switch "Nama Store" label to "Nama Vendor" when role is vendor
            const roleSelect = document.getElementById('role');
            const storeLabel = document.getElementById('storeLabel');
            const storeInput = document.getElementById('store_name');

            // Expose update function globally so other handlers (like nextStep) can call it
            window.updateStoreLabel = function() {
                if (!roleSelect || !storeLabel || !storeInput) return;
                const isVendor = roleSelect.value === 'vendor';
                storeLabel.textContent = isVendor ? 'Nama Vendor' : 'Nama Store';
                // Update placeholder to give clearer hint for vendor
                storeInput.placeholder = isVendor ? 'Nama Vendor' : 'Mcd';
            };

            if (roleSelect) {
                roleSelect.addEventListener('change', window.updateStoreLabel);
                // Initialize on load
                window.updateStoreLabel();
            }
        });

        // Submit form with validation
        function submitForm() {
            // Validate step 3 before submitting
            if (validateStep(3)) {
                document.getElementById('register-form').submit();
            }
        }
    </script>
</body>
</html>
