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
                            {{ __('User update') }}
                        </h2>

                        {{-- <p class="mt-1 text-sm text-gray-600">
                            {{ __("Update your account's profile information and email address.") }}
                        </p> --}}
                    </header>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <form method="post" action="/manage_users/edit_adduser/{{ $user->id }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus
                                autocomplete="name" value="{{ $user->name }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="cid" :value="__('CID')" />
                            <x-text-input id="cid" name="cid" type="text" class="mt-1 block w-full" required autofocus
                                autocomplete="cid" value="{{ $user->cid }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('cid')" />
                        </div>

                        <div>
                            <x-text-input id="client_org" name="client_org" type="hidden" class="mt-1 block w-full"
                                required autofocus autocomplete="client_org" value="{{ $user->client_org }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('client_org')" />
                        </div>
                        <div>
                            <x-input-label for="organization" :value="__('Organization')" />
                            <x-text-input id="organization" name="organization" type="text" class="mt-1 block w-full"
                                required autofocus autocomplete="organization" value="{{ $user->organization }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('organization')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required
                                autocomplete="username" value="{{ $user->email }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        </div>

                        <div>
                            <x-input-label for="contact" :value="__('Contact')" />
                            <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full" required
                                autofocus autocomplete="contact" value="{{ $user->contact }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('contact')" />
                        </div>

                        {{-- <div>
                            <x-input-label for="organization" :value="__('Organization')" />
                            <select id="organization" class="block mt-1 w-full" name="organization" required autofocus>
                                <option value="" disabled selected>Select an organization</option>
                                @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}" {{ $user->organization ==
                                    $organization->id ? 'selected' : '' }}>{{ $organization->org_name}}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('organization')" />
                        </div> --}}

                        <br>

                        {{-- <table>
                            @foreach($cid_files as $file)
                            <tr>
                                @if(substr($file->path, strpos($file->path, '.')+1) == 'pdf')
                                <td>
                                    <a href="{{ asset('storage/'. $file->path) }}" target="_blank">
                                        View Attach File
                                    </a>
                                    @else
                                    <a href="{{ asset('storage/'. $file->path) }}" target="_blank">
                                        <img src="{{ asset('storage/'. $file->path) }}" height="100" width="100" />
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table> --}}

                        <!-- Multiple passport photos -->
                        {{-- <div class="mt-4">
                            <x-input-label for="update_photos" :value="__('Upload CID (Front)')" />
                            <input id="update_photos" name="update_photos[]" type="file" class="mt-1 block w-full"
                                accept=".jpg, .jpeg, .png, .pdf" required multiple />
                            <x-input-error class="mt-2" :messages="$errors->get('update_photos.*')"   />
                        </div> --}}

                        <hr>

                        <div class="flex items-center gap-4">
                            <x-primary-button name="flag" value="1">{{ __('Submit') }}</x-primary-button>
                            {{-- <x-primary-button name="flag" value="0">{{ __('Reject') }}</x-primary-button> --}}
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