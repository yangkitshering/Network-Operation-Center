<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('User View') }}
                        </h2>
                    </header>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <!-- jQuery -->
                    <script src="{{ asset('js/jquery.min.js') }}"></script>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
                        rel="stylesheet">
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js">
                    </script>

                    @if($user != null)
                    <form method="post" action="/user_pending/{{ $user->id }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus
                                autocomplete="name" value="{{ $user->name }}" readonly />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="cid" :value="__('CID')" />
                            <x-text-input id="cid" name="cid" type="text" class="mt-1 block w-full" required autofocus
                                autocomplete="cid" value="{{ $user->cid }}" readonly />
                            <x-input-error class="mt-2" :messages="$errors->get('cid')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required
                                autocomplete="username" value="{{ $user->email }}" readonly />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        </div>

                        <div>
                            <x-input-label for="contact" :value="__('Contact')" />
                            <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full" required
                                autofocus autocomplete="contact" value="{{ $user->contact }}" readonly />
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
                        <br>

                        <table>
                            @foreach($cid_files as $file)
                            <tr>
                                @if(substr($file->path, strpos($file->path, '.')+1) == 'pdf')
                                <td>
                                    <a href="{{ asset('storage/'. $file->path) }}" target="_blank">
                                        {{-- <input type="text"
                                            value="{{substr($file->path, strpos($file->path, '.')+1)}}" /> --}}
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
                        </table>

                        <hr>

                        <div class="flex items-center gap-4">
                            {{-- <x-primary-button name="flag" value="1">{{ __('Approve') }}</x-primary-button> --}}
                            @method('PUT')
                            <button type="submit" class="btn btn-success" name="flag" value="1">Approve</button>
                            <button type="button" class="btn btn-danger reject-button open_Modal"
                                value="{{ $user->id }}">Reject</button>
                            {{-- <x-primary-button name="flag" value="0">{{ __('Reject') }}</x-primary-button> --}}
                        </div>
                    </form>
                    {{-- <div class="flex items-center gap-4">
                        <x-primary-button name="flag" value="0">{{ __('Reject') }}</x-primary-button>
                    </div> --}}
                    @endif

                    @if (session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                                    Swal.fire({
                                        title: '{{ session('title') }}',
                                        text: '{{ session('success') }}',
                                        icon: '{{ session('icon') }}',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if(result.isConfirmed){
                                            window.location.href = "{{ route('user-pending')}}";
                                        }
                                    });
                                });
                    </script>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready( function(){
            $('.open_Modal').click(function(e){
                e.preventDefault();
                var id = $(this).val();
                $('#id').val(id);
                $('#show_Modal').modal('show');
            });
        });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="show_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> --}}
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($user != null)
                    <form action="/user_pending/{{ $user->id }}" method="post">
                        <input type="hidden" id="id" name="user_id" />
                        <div class="form-group col-md-12">
                            <label for="organization">State reject reason</label>
                            <textarea type="text" class="form-control" id="reject" name="rejectReason"
                                placeholder="Please state your reject reason" required></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="form-control btn-info" id="submitBtn" value="0"
                                name='flag'>Submit</button>
                        </div>
                        {{-- <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div> --}}
                    </form>
                    @endif
                </div>

            </div>
        </div>
    </div>

</x-app-layout>