<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <div class="col-md-12">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Add DC Focal') }}
                            </h2>
                        </header>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <form method="POST" action="{{ route('save_focal') }}" >
                            @csrf

                            <!-- DC list dropdown -->
                            <div class="mt-4">
                                <x-input-label for="dc_id" :value="__('Data Center')" />
                                <select id="dc_id" class="block mt-1 w-full" name="dc_id" required autofocus>
                                    <option value="" disabled selected>Select Data Center</option>
                                    @foreach($dc_list as $dc)
                                    <option value="{{ $dc->id }}" {{ $dc->id ==
                                        Auth::user()->dc_id ? 'selected' : '' }}>{{ $dc->dc_name}}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('organization')" class="mt-2"   />
                            </div>

                            <!--Focal Name -->
                            <div class="mt-4">
                                <x-input-label for="focal_name" :value="__('Name')" />
                                <x-text-input id="focal_name" class="block mt-1 w-full" type="text" name="focal_name"
                                    :value="old('focal_name')" required autofocus autocomplete="focal_name" />
                                <x-input-error :messages="$errors->get('focal_name')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                                    autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Focal Contact -->
                            <div class="mt-4">
                                <x-input-label for="focal_contact" :value="__('Contact Number')" />
                                <x-text-input id="focal_contact" class="block mt-1 w-full" type="text" name="focal_contact"
                                    :value="old('focal_contact')" required autofocus autocomplete="focal_contact" />
                                <x-input-error :messages="$errors->get('focal_contact')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-center mt-4">
                                <x-primary-button class="ml-4">
                                    {{ __('Save') }}
                                </x-primary-button>
                            </div>
                        </form>

                        @if (session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        title: 'Success',
                                        text: '{{ session('success') }}',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if(result.isConfirmed){
                                            window.location.href = "{{ route('manage-setting')}}";
                                        }
                                    });
                                });
                        </script>
                        @endif

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>