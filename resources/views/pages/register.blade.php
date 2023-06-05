<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2> --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Fill up and submit your request for approval') }}
                        </h2>

                        {{-- <p class="mt-1 text-sm text-gray-600">
                            {{ __("Update your account's profile information and email address.") }}
                        </p> --}}
                    </header>


                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <form id="register" method="post" action="{{ route('save.register') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus
                                autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required
                                autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        </div>

                        <div>
                            <x-input-label for="contact" :value="__('Contact')" />
                            <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full" required
                                autofocus autocomplete="contact" />
                            <x-input-error class="mt-2" :messages="$errors->get('contact')" />
                        </div>

                        <div>
                            <x-input-label for="organization" :value="__('Organization Name')" />
                            <x-text-input id="organization" name="organization" type="text" class="mt-1 block w-full"
                                required autofocus autocomplete="organization" />
                            <x-input-error class="mt-2" :messages="$errors->get('organization')" />
                        </div>

                        <div>
                            <x-input-label for="rack" :value="__('Rack No')" />
                            <select id="rack" name="rack" class="mt-1 block w-full" required autofocus
                                autocomplete="rack">
                                <option>Select your rack </option>
                                @foreach($rackList as $rack)
                                <option value="{{ $rack->id }}">{{ $rack->rack_no }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('reason')" />
                        </div>

                        <div>
                            <x-input-label for="reason" :value="__('Reason')" />
                            <textarea id="reason" name="reason" type="text" class="mt-1 block w-full" required autofocus
                                autocomplete="reason"></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('reason')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
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
                            });
                        });
                    </script>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>