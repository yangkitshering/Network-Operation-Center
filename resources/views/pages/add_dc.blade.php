<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <div class="col-md-12">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"> --}}
                    <div class="max-w-xl">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Add DC') }}
                            </h2>

                            {{-- <p class="mt-1 text-sm text-gray-600">
                                {{ __("Update your account's profile information and email address.") }}
                            </p> --}}
                        </header>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <form method="POST" action="{{ route('save_dc') }}" >
                            {{-- <form method="post" action="{{ route('save_dc') }}"> --}}
                            @csrf

                            <!--DC Name -->
                            <div>
                                <x-input-label for="dc_name" :value="__('DC Name')" />
                                <x-text-input id="dc_name" class="block mt-1 w-full" type="text" name="dc_name"
                                    :value="old('dc_name')" required autofocus autocomplete="dc_name" />
                                <x-input-error :messages="$errors->get('dc_name')" class="mt-2" />
                            </div>

                              <!-- DC Location -->
                              <div>
                                <x-input-label for="dc_location" :value="__('DC Location')" />
                                <x-text-input id="dc_location" class="block mt-1 w-full" type="text" name="dc_location"
                                    :value="old('dc_location')" required autofocus autocomplete="dc_location" />
                                <x-input-error :messages="$errors->get('dc_location')" class="mt-2" />
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