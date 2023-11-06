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
                                {{ __('Add Rack') }}
                            </h2>
                        </header>
                        
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        {{-- <form method="POST" action="{{ route('save_organization') }}" enctype="multipart/form-data"> --}}
                            <form method="POST" action="{{ route('save_racklist') }}" enctype="multipart/form-data">
                            @csrf

                             {{-- DC list dropdown --}}
                             <div class="mt-4">
                                <x-input-label for="racklist" :value="__('Organization')" />
                                <select id="racklist" class="block mt-1 w-full" name="org_id" required autofocus>
                                    <option value="" disabled selected>Select Organization</option>
                                    @foreach($org_list as $org)
                                    <option value="{{ $org->id }}" {{ $org->id ==
                                        Auth::user()->organization ? 'selected' : '' }}>{{ $org->org_name}}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('racklist')" class="mt-2"  />
                                </div>

                            <!-- Name -->
                            
                                <div class="mt-4">
                                <x-input-label for="rack_no" :value="__('Rack Number')" />
                                <x-text-input id="rack_no" class="block mt-1 w-full" type="text" name="rack_no"
                                    :value="old('rack_no')" required autofocus autocomplete="rack_no" />
                                <x-input-error :messages="$errors->get('rack_no')" class="mt-2" />
                            </div>

                            <!-- CID -->
                            <div class="mt-4">
                                <x-input-label for="rack_name" :value="__('Rack Name')" />
                                <x-text-input id="rack_name" class="block mt-1 w-full" type="text" name="rack_name"
                                    :value="old('rack_name')" required autofocus autocomplete="rack_name" length="11" />
                                <x-input-error :messages="$errors->get('rack_name')" class="mt-2" />
                            </div>                          

                            <div class="mt-4">
                                <x-input-label for="desc" :value="__('Rack Description')" />
                                <x-text-input id="desc" class="block mt-1 w-full" type="text" name="desc"
                                    :value="old('desc')" required autofocus autocomplete="desc" length="11" />
                                <x-input-error :messages="$errors->get('desc')" class="mt-2" />
                            </div> &nbsp;&nbsp;

                           

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