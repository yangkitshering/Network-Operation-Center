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
                                {{ __('Edit Organization') }}
                            </h2>
                        </header>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <form method="POST" action="{{ route('save_organization') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $org->id }}" />
                            <!-- DC list dropdown -->
                            <div class="mt-4">
                                <x-input-label for="dc_id" :value="__('Data Center')" />
                                <select id="dc_id" class="block mt-1 w-full" name="dc_id" required autofocus>
                                    <option value="" disabled selected>Select Data Center</option>
                                    @foreach($dc_list as $dc)
                                    <option value="{{ $dc->id }}" {{ $dc->id ==
                                        $org->dc_id ? 'selected' : '' }}>{{ $dc->dc_name}}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('organization')" class="mt-2"   />
                            </div>

                            <!-- Name -->
                            <div class="mt-4">
                                <x-input-label for="org_name" :value="__('Organization Name')" />
                                <x-text-input id="org_name" class="block mt-1 w-full" type="text" name="org_name"
                                    :value="old('org_name', $org->org_name)" required autofocus
                                    autocomplete="org_name" />
                                <x-input-error :messages="$errors->get('org_name')" class="mt-2" />
                            </div>

                            <!-- CID -->
                            <div class="mt-4">
                                <x-input-label for="org_address" :value="__('Organization Address')" />
                                <x-text-input id="org_address" class="block mt-1 w-full" type="text" name="org_address"
                                    :value="old('org_address', $org->org_address)" required autofocus
                                    autocomplete="org_address" />
                                <x-input-error :messages="$errors->get('org_address')" class="mt-2" />
                            </div>

                            <!-- Form inputs here -->
                            <div class="mt-4">
                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Update') }}</x-primary-button>
                                </div>
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
</x-app-layout>