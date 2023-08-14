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

                    {{-- time picker add on --}}

                    {{--
                    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css"
                        integrity="sha512-LT9fy1J8pE4Cy6ijbg96UkExgOjCqcxAC7xsnv+mLJxSvftGVmmc236jlPTZXPcBRQcVOWoK1IJhb1dAjtb4lQ=="
                        crossorigin="anonymous" referrerpolicy="no-referrer" />
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                    <script
                        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"
                        integrity="sha512-s5u/JBtkPg+Ff2WEr49/cJsod95UgLHbC00N/GglqdQuLnYhALncz8ZHiW/LxDRGduijLKzeYb7Aal9h3codZA=="
                        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}


                    <script>
                        $(document).ready(function() {
                            flatpickr('.datetime', {
                            enableTime: true,
                            dateFormat: "Y-m-d H:i",
                            });
                        //   $("#visitFrom").datetimepicker({
                        //     dateFormat: "yy-mm-dd",
                        //     timeFormat: "HH:mm",

                        //     // Additional options can be added here
                        //   });
                        $('.flatpickr-input:visible').prop('readonly', false)
                        });
                        
                    </script>


                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <form method="post" action="{{ route('save') }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            {{--
                            <x-input-label for="name" :value="__('Name')" /> --}}
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full hidden" required
                                autofocus autocomplete="name" value="{{ Auth::user()->name }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            {{--
                            <x-input-label for="cid" :value="__('CID')" /> --}}
                            <x-text-input id="cid" name="cid" type="text" class="mt-1 block w-full hidden" required
                                autofocus autocomplete="cid" value="{{ Auth::user()->cid }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('cid')" />
                        </div>

                        <div>
                            {{--
                            <x-input-label for="email" :value="__('Email')" /> --}}
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full hidden" required
                                autocomplete="username" value="{{ Auth::user()->email }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        </div>

                        <div>
                            {{--
                            <x-input-label for="contact" :value="__('Contact')" /> --}}
                            <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full hidden"
                                required autofocus autocomplete="contact" value="{{ Auth::user()->contact }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('contact')" />
                        </div>

                        <div>
                            {{--
                            <x-input-label for="organization" :value="__('Organization Name')" /> --}}
                            <x-text-input id="organization" name="organization" type="text"
                                class="mt-1 block w-full hidden" required autofocus autocomplete="organization"
                                value="{{ Auth::user()->organization }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('organization')" />
                        </div>

                        <div>
                            <x-input-label for="visitFrom" :value="__('Vist From Date')" />
                            <input id="visitFrom" name="visitFrom" type="text"
                                class=" datetime form-control mt-1 block w-full" required autofocus
                                autocomplete="visitFrom" />
                            <x-input-error class="mt-2" :messages="$errors->get('visitFrom')" />
                        </div>

                        <div>
                            <x-input-label for="visitTo" :value="__('Vist To Date')" />
                            <input id="visitTo" name="visitTo" type="text"
                                class=" datetime form-control mt-1 block w-full" required autofocus
                                autocomplete="visitTo" />
                            <x-input-error class="mt-2" :messages="$errors->get('visitTo')" />
                        </div>

                        <div>
                            <x-input-label for="rack" :value="__('Rack Number')" />
                            <select id="rack" name="rack" class="mt-1 block w-full" required autofocus
                                autocomplete="rack">
                                <option value="">Select your rack number</option>
                                @foreach($rackList as $rack)
                                <option value="{{ $rack->id }}">{{ $rack->rack_no }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('rack')" />
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