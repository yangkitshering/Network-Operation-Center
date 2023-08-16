<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Approval for Server Access') }}
        </h2> --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <link rel="stylesheet" href="{{ asset('css/card.css') }}">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <div class="card">
                        <div class="card-header">User Details</div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>CID</th>
                                    <td>{{ $user->cid }}</td>
                                </tr>
                                <tr>
                                    <th>Organization</th>
                                    <td>{{ $user->organization }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Contact</th>
                                    <td>{{ $user->contact }}</td>
                                </tr>

                                @foreach($cid_files as $file)
                                    <tr>
                                        <th>Attach File</th>
                                        @if(substr($file->path, strpos($file->path, '.')+1) == 'pdf')
                                        <td>
                                            <a href="{{ asset('storage/'. $file->path) }}" target="_blank">
                                                {{-- <input type="text"
                                                    value="{{substr($file->path, strpos($file->path, '.')+1)}}" /> --}}
                                                View Attach File
                                            </a>
                                        </td>
                                            @else
                                           <td>
                                            <a href="{{ asset('storage/'. $file->path) }}" target="_blank">
                                                <img src="{{ asset('storage/'. $file->path) }}" height="100"
                                                    width="100" />
                                            </a>
                                        </td>
                                            @endif
                                        
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <th>Approve</th>
                                        <td><div>
                                            <label for="role" class="col-md-1 col-form-label text-md-right">{{ __('Approve')
                                                }}</label>
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" class="" id="verify" name="verify" value="1"
                                                @if($user->verified ==
                                            1)
                                            checked
                                            @endif>
                                        </div></td>
                                    </tr>
                                {{-- <tr>
                                    <th>rack Number</th>
                                    <td>{{ $requests->rack_no }}</td>
                                </tr>
                                <tr>
                                    <th>rack Name</th>
                                    <td>{{ $requests->rack_name }}</td>
                                </tr>
                                <tr>
                                    <th>reason</th>
                                    <td>{{ $requests->reason }}</td>
                                </tr>
                                <tr>
                                    <th>Visit From</th>
                                    <td>{{ $requests->visitFrom }}</td>
                                </tr>
                                <tr>
                                    <th>Visit To</th>
                                    <td>{{ $requests->visitTo }}</td>
                                </tr> 
                                <tr>
                                    <th>Status</th>
                                    @if($requests->status == 'I')
                                    <td>{{'Pending'}}</td>
                                    @elseif ($requests->status == 'A')
                                    <td>{{'Approved'}}</td>
                                    @else
                                    <td>{{'Rejected'}}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Exited</th>
                                    @if($requests->exited == 0)
                                    <td>{{'No'}}</td>
                                    @else
                                    <td>{{'Yes'}}</td>
                                    @endif
                                </tr>--}}
                                {{-- @if($user->status == 'I')
                                <tr>
                                    <th></th>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <form id="approve-form" method="POST"
                                                action="{{ route('approve_reject', $user->id) }}"
                                                class="approval-form">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success approve-button" value="1"
                                                    name='flag'>Approve</button>
                                            </form>
                                            <form id="reject-form" method="POST"
                                                action="{{ route('approve_reject', $user->id) }}"
                                                class="approval-form">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger reject-button" value="0"
                                                    name='flag'>Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endif --}}
                            </table>

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
        </div>
    </div>

</x-app-layout>