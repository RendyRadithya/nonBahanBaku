<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Photo Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl mx-auto">
                    <section>
                        <header class="text-center">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Profile Photo') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Update your profile picture.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('profile.photo.update') }}" class="mt-6" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <!-- Centered Photo with Edit Button -->
                            <div class="flex justify-center">
                                <div class="relative w-24 h-24 sm:w-32 sm:h-32">
                                    @if($user->profile_photo)
                                        <!-- Show uploaded photo -->
                                        <img class="rounded-full object-cover border-4 border-gray-200 shadow-lg w-24 h-24 sm:w-32 sm:h-32 max-w-full" 
                                             src="{{ asset('storage/' . $user->profile_photo) }}" 
                                             alt="Profile Photo" 
                                             id="photo-preview">
                                        <div class="rounded-full bg-red-600 items-center justify-center text-white text-3xl sm:text-4xl font-bold border-4 border-gray-200 shadow-lg hidden flex items-center justify-center" id="photo-placeholder">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @else
                                        <!-- Show initial placeholder -->
                                        <div class="rounded-full bg-red-600 flex items-center justify-center text-white text-3xl sm:text-4xl font-bold border-4 border-gray-200 shadow-lg" id="photo-placeholder">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <img class="rounded-full object-cover border-4 border-gray-200 shadow-lg hidden w-24 h-24 sm:w-32 sm:h-32 max-w-full absolute top-0 left-0" 
                                             src="" 
                                             alt="Profile Photo" 
                                             id="photo-preview">
                                    @endif
                                    
                                    <!-- Pencil Edit Button -->
                                    <label for="profile_photo" class="absolute bg-white rounded-full p-2 shadow-lg border-2 border-gray-300 cursor-pointer hover:bg-gray-100 transition" style="bottom: 5px; right: 5px;">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </label>
                                    
                                    <!-- Hidden File Input -->
                                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden" onchange="previewImage(this)">
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <p class="text-xs text-gray-500">Klik ikon pensil untuk memilih foto</p>
                                <p class="text-xs text-gray-400">PNG, JPG, GIF, WEBP (Max. 10MB)</p>
                                <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
                            </div>

                            <div class="flex justify-center mt-6">
                                <x-primary-button id="save-photo-btn" style="display: none;">{{ __('Save Photo') }}</x-primary-button>

                                @if (session('status') === 'photo-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('photo-preview');
                    const placeholder = document.getElementById('photo-placeholder');
                    
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                    
                    // Show save button
                    document.getElementById('save-photo-btn').style.display = 'inline-flex';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
