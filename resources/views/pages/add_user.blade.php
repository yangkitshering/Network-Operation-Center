<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <div class="col-md-12">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Add User') }}
                            </h2>

                            {{-- <p class="mt-1 text-sm text-gray-600">
                                {{ __("Update your account's profile information and email address.") }}
                            </p> --}}
                        </header>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <form method="POST" action="{{ route('save_user') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- CID -->
                            <div class="mt-4">
                                <x-input-label for="cid" :value="__('CID Number')" />
                                <x-text-input id="cid" class="block mt-1 w-full" type="text" name="cid"
                                    :value="old('cid')" required autofocus autocomplete="cid" length="11" />
                                <x-input-error :messages="$errors->get('cid')" class="mt-2" />
                            </div>

                            <!-- Organization -->
                            {{-- <div class="mt-4">
                                <x-input-label for="organization" :value="__('Organization Name')" />
                                <select id="organization" class="block mt-1 w-full" name="organization" required
                                    autofocus>
                                    <option value="" disabled selected>Select an organization</option>
                                    @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->org_name}}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('organization')" class="mt-2" />
                            </div> --}}

                            <div>
                                {{--
                                <x-input-label for="client_org" :value="__('client_org')" /> --}}
                                <x-text-input id="client_org" name="client_org" type="hidden" class="mt-1 block w-full"
                                    required autofocus autocomplete="client_org"
                                    value="{{ Auth::user()->organization }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('client_org')" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="organization" :value="__('Organization')" />
                                <x-text-input id="organization" class="block mt-1 w-full" type="text"
                                    name="organization" :value="old('organization')" required autofocus
                                    autocomplete="organization" />
                                <x-input-error :messages="$errors->get('organization')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Mobile number -->
                            <div class="mt-4">
                                <x-input-label for="contact" :value="__('Mobile Number')" />
                                <x-text-input id="contact" class="block mt-1 w-full" type="text" name="contact"
                                    :value="old('contact')" required autofocus autocomplete="contact" />
                                <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                            </div>

                            <!-- Multiple CID photos -->
                            <div class="mt-4">
                                <x-input-label for="files" :value="__('Upload Passport Size Photo')" />
                                <input id="files" name="files[]" type="file" class="mt-1 block w-full"
                                    accept=".jpg, .jpeg, .png, .pdf" required multiple />
                                <x-input-error class="mt-2" :messages="$errors->get('files.*')" />
                            </div>

                            <div class="flex items-center justify-center mt-4">
                                <x-primary-button class="ml-4">
                                    {{ __('Submit') }}
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
                                            window.location.href = "{{ route('manage-user')}}";
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