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
                    <style>
                        .card-body table {
                            border-collapse: collapse;
                        }

                        .card-body th, .card-body td {
                            border: none;
                            padding: 0.5rem;
                        }

                        .card-body th {
                            text-align: left;
                            font-weight: bold;
                        }
                    </style>

                    <div class="card">
                        <div class="card-header">User Request Details</div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <th>Requester Name</th>
                                    <td>{{ $requests->name }}</td>
                                </tr>
                                <tr>
                                    <th>CID</th>
                                    <td>{{ $requests->cid }}</td>
                                </tr>
                                <tr>
                                    <th>Organization Name</th>
                                    <td>{{ $requests->org_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email Address</th>
                                    <td>{{ $requests->email }}</td>
                                </tr>
                                <tr>
                                    <th>Contact No</th>
                                    <td>{{ $requests->contact }}</td>
                                </tr>
                                <tr>
                                    <th>Rack Number</th>
                                    <td>{{ $requests->rack_no }}</td>
                                </tr>
                                <tr>
                                    <th>Rack Name</th>
                                    <td>{{ $requests->rack_name }}</td>
                                </tr>
                                <tr>
                                    <th>Purpose of Visit</th>
                                    <td>{{ $requests->reason }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Visit From</th>
                                    <td>{{ $requests->visitFrom }}</td>
                                </tr>
                                <tr>
                                    <th>Visit To</th>
                                    <td>{{ $requests->visitTo }}</td>
                                </tr> --}}
                                <tr>
                                    <th>Approximate Date & Time</th>
                                    <td class="pr-1">{{ $requests->visitTo }}</td>
                                    <td>{{ $requests->visitFrom }}</td>
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
                                {{-- <tr>
                                    <th>Exited</th>
                                    @if($requests->exited == 0)
                                    <td>{{'No'}}</td>
                                    @else
                                    <td>{{'Yes'}}</td>
                                    @endif
                                </tr> --}}
                                @if(Auth::user()->hasRole('admin'))
                                @if($requests->status == 'I')
                                <tr>
                                    <th>Action</th>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <form id="approve-form" method="POST"
                                                action="{{ route('approve_reject', $requests->id) }}"
                                                class="approval-form">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success approve-button" value="1"
                                                    name='flag'>Approve</button>
                                            </form>
                                            <form id="reject-form" method="POST"
                                                action="{{ route('approve_reject', $requests->id) }}"
                                                class="approval-form">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger reject-button" value="0"
                                                    name='flag'>Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endif
                            </table>

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
                                            window.location.href = "{{ route('pendingList')}}";
                                        }
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