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

                    <link rel="stylesheet" type="text/css"
                        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
                    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
                    <script type="text/javascript"
                        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js">
                    </script>
                    <link rel="stylesheet" type="text/css"
                        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

                    <style>
                        body {
                            background: #0083B0;
                            background: -webkit-linear-gradient(to right, #0083B0, #00B4DB);
                            background: linear-gradient(to right, #0083B0, #00B4DB);
                            min-height: 100vh;
                        }

                        .form-control::placeholder {
                            font-style: italic;
                            font-size: 0.85rem;
                            color: #aaa;
                        }
                    </style>


                    <form method="post" action="{{ route('save') }}" class="mt-6 space-y-6"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- <div>
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full hidden" required
                                autofocus autocomplete="name" value="{{ Auth::user()->name }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-text-input id="cid" name="cid" type="text" class="mt-1 block w-full hidden" required
                                autofocus autocomplete="cid" value="{{ Auth::user()->cid }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('cid')" />
                        </div>

                        <div>
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full hidden" required
                                autocomplete="username" value="{{ Auth::user()->email }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        </div>

                        <div>
                            <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full hidden"
                                required autofocus autocomplete="contact" value="{{ Auth::user()->contact }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('contact')" />
                        </div> --}}

                        <div class="mt-4">
                            <x-input-label for="requester" :value="__('Requester')" />
                            <select id="dc" class="block mt-1 w-full" name="requester" required autofocus>
                                <option value="" disabled selected>Select requester</option>
                                <option value="{{Auth::user()->id}}">{{Auth::user()->name}} ({{$org_name}})</option>
                                @foreach($add_users as $usr)
                                <option value="{{ $usr->user_id }}">{{ $usr->name }} ({{$usr->organization}})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('requester')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="dc" :value="__('Data Center')" />
                            <select id="dc" class="block mt-1 w-full" name="dc" required autofocus>
                                <option value="" disabled selected>Select a data center</option>
                                @if(Auth::user()->is_thim_dc == 1)
                                <option value="{{ 1 }}">{{ 'Thimphu DC' }}</option>
                                @endif
                                @if(Auth::user()->is_pling_dc == 1)
                                <option value="{{ 2 }}">{{ 'Phuntsholing DC' }}</option>
                                @endif
                                @if(Auth::user()->is_jakar_dc == 1)
                                <option value="{{ 3 }}">{{ 'Jakar DC' }}</option>
                                @endif
                                {{-- @foreach($dc_lists as $dc)
                                <option value="{{ $dc->id }}" {{ $dc->id ==
                                        Auth::user()->dc_id ? 'selected' : '' }}>{{ $dc->dc_name }}</option>
                                @endforeach --}}
                            </select>
                            <x-input-error :messages="$errors->get('dc')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="organization" :value="__('Organization Name')" />
                            <select id="organization" class="block mt-1 w-full" name="organization" required autofocus>
                                <option value="" disabled selected>Select an organization</option>
                                @foreach($organizations as $org)
                                <option value="{{ $org->id }}" {{ $org->id ==
                                        Auth::user()->organization ? 'selected' : '' }}>{{ $org->org_name}}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('organization')" class="mt-2"   />
                        </div>

                        <div>
                            <x-input-label for="rack" :value="__('Rack Name')" />
                            <select id="rack" name="rack" class="mt-1 block w-full" required autofocus
                                autocomplete="rack">
                                <option value="">Select your rack</option>
                                @foreach($rack_lists as $rack)
                                <option value="{{ $rack->id }}">{{ $rack->rack_name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('rack')" />
                        </div>

                        <div class="flex flex-col">
                            <div class="flex flex-col items-start">
                                <!-- Flex direction set to column and items to end for labels to appear in front -->
                                <div class="mb-1">
                                    <x-input-label for="organization" :value="__('Approximate Visit Date & Time')"
                                        class="text-gray-700" />
                                </div>

                                <div class="flex space-x-2 items-center">
                                    <label for="visitFrom" class="text-gray-600">From </label>
                                    <input id="visitFrom" name="visitFrom" type="text" class="datetime form-control"
                                        required autofocus autocomplete="visitFrom" />
                                    <div></div>

                                    <label for="visitTo" class="text-gray-600">To</label>
                                    <input id="visitTo" name="visitTo" type="text"
                                        class="datetime form-control w-full border border-gray-700" required autofocus
                                        autocomplete="visitTo" />
                                </div>
                            </div>
                        </div>
                        {{-- Addtional users --}}
                        {{-- <div class="mt-4">
                            <x-input-label for="users" :value="__('Additional users')" />
                            <select id="users" class="js-example-basic-multiple block mt-1 w-full" name="users[]"
                                multiple>
                                @foreach($add_users as $usr)
                                <option value="{{$usr->id}}">{{$usr->name}} ({{$usr->organization}})</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <!-- This is for add more visitor -->
                        <div class="mt-4">
                            <x-input-label for="add_users" :value="__('Additional users')" />
                            <!--  Bootstrap table-->
                            <div class="table-responsive">
                                <table class="table">
                                    {{-- <thead>
                                    </thead> --}}
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <!-- Add rows button-->
                            <a class="btn btn-outline-info rounded-0" id="insertRow" href="#">Add Visitor <b
                                    style="color:black">&#x002B;</b></a>
                        </div>
                        
                        <div>
                            <x-input-label for="reason" :value="__('Purpose of Visit')" />
                            <textarea id="reason" name="reason" type="text" class="mt-1 block w-full" required autofocus
                                autocomplete="reason"></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('reason')" />
                        </div>

                        <!-- Multiple passport photos -->
                        <div class="mt-4">
                            <x-input-label for="passport_photos" :value="__('Upload Passport Size Photo')" />
                            <input id="passport_photos" name="passport_photos[]" type="file" class="mt-1 block w-full"
                                accept=".jpg, .jpeg, .png" required multiple />
                            <x-input-error class="mt-2" :messages="$errors->get('passport_photos.*')" />
                            @error('passport_photos.*')
                            <span class="text-red-500 text-sm !important">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Submit') }}</x-primary-button>
                        </div>
                    </form>

                    <script>
                        const visitFromInput = document.getElementById('visitFrom');
                        const visitToInput = document.getElementById('visitTo');
                    
                        visitFromInput.addEventListener('change', validateDates);
                        visitToInput.addEventListener('change', validateDates);
                    
                        function validateDates() {
                            const visitFromDate = new Date(visitFromInput.value);
                            const visitToDate = new Date(visitToInput.value);
                    
                            if (visitToDate < visitFromDate) {
                                visitToInput.setCustomValidity('Visit To Date must be greater than or equal to Visit From Date.');
                            } else {
                                visitToInput.setCustomValidity('');
                            }
                        }
                    </script>

                    @if(session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: '{{ session('title') }}',
                                text: '{{ session('success') }}',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if(result.isConfirmed){
                                    window.location.href = "{{ route('dashboard')}}";
                                }
                            });
                        });
                    </script>
                    @endif

                    <script>
                        $(function () {
                            // Start counting from the third row
                            var counter = 1;
                        
                            $("#insertRow").on("click", function (event) {
                                event.preventDefault();
                        
                                var newRow = $("<tr>");
                                var cols = '';
                        
                                // Table columns
                                // cols += '<th scrope="row">' + counter + '</th>';
                                cols += '<td><span class="input-group-addon">Name</span><input class="form-control rounded-0" type="text" name="vname[]" placeholder="Name" required></td>';
                                cols += '<td><span class="input-group-addon">CID</span><input class="form-control rounded-0" type="text" name="vcid[]" placeholder="CID" required></td>';
                                cols += '<td><span class="input-group-addon">Organization</span><input class="form-control rounded-0" type="text" name="vorg[]" placeholder="Organization" required></td>';
                                cols += '<td><label></label> </span><button class="btn btn-danger rounded-0" id ="deleteRow"><i class="fa fa-trash"></i></button</td>';
                        
                                // Insert the columns inside a row
                                newRow.append(cols);
                        
                                // Insert the row inside a table
                                $("table").append(newRow);
                        
                                // Increase counter after each row insertion
                                // counter++;
                            });
                        
                            // Remove row when delete btn is clicked
                            $("table").on("click", "#deleteRow", function (event) {
                                $(this).closest("tr").remove();
                                // counter -= 1
                            });
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>