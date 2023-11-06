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
                    </header>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <form id="myForm" method="post" action="/manage_users/{{ $user->id }}" class="mt-6 space-y-6">
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

                        <div>
                            <x-input-label for="organization" :value="__('Organization')" />
                            <select id="organization" class="block mt-1 w-full" name="organization" required autofocus>
                                <option value="" disabled selected>Select an organization</option>
                                @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}" {{ $user->organization ==
                                    $organization->id ? 'selected' : '' }}>{{ $organization->org_name}}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('organization')" />
                        </div>

                        <div>
                            <p>Data Center</p>
                            <div>
                                <input type="checkbox" name="thim" value="1" @if($user->is_thim_dc) checked @endif>
                                Thimphu DC &nbsp; &nbsp;
                                <input type="checkbox" name="pling" value="1" @if($user->is_pling_dc) checked @endif>
                                Pling DC &nbsp; &nbsp;
                                <input type="checkbox" name="jakar" value="1" @if($user->is_jakar_dc) checked @endif>
                                Jakar DC
                            </div>
                        </div>

                        <br>
                        <div>
                            <label for="role" class="col-md-1 col-form-label text-md-right">{{ __('Role') }}</label>

                            <input type="radio" class="" name="roletype" value="user"
                                @if($user->hasRole('user')) checked @endif> User &nbsp;&nbsp;&nbsp;

                            <input type="radio" class="" name="roletype" value="admin"
                                @if($user->hasRole('admin')) checked @endif> Admin
                        </div>
                        <hr>

                        <div class="flex items-center gap-4">
                            <x-primary-button name="flag" value="1">{{ __('Submit') }}</x-primary-button>
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
                                if (result.isConfirmed) {
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
