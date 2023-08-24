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
                    <!-- jQuery -->
                    <script src="{{ asset('js/jquery.min.js') }}"></script>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
                        rel="stylesheet">
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js">
                    </script>
                    <style>
                        .card-body table {
                            border-collapse: collapse;
                        }

                        .card-body th,
                        .card-body td {
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
                                    <td class="pr-1"> <b>From:&nbsp;</b> {{ $requests->visitFrom }}</td>
                                    <td><b>To: &nbsp;</b>{{ $requests->visitTo }}</td>
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
                                            {{-- <form id="reject-form" method="POST"
                                                action="{{ route('approve_reject', $requests->id) }}"
                                                class="approval-form">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger reject-button" value="0"
                                                    name='flag'>Reject</button>
                                            </form> --}}
                                            <button type="button" class="btn btn-danger reject-button openReasonModal"
                                                value="{{ $requests->id }}">Reject</button>
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
                                title: '{{ session('title') }}',
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

    <script>
        $(document).ready( function(){
            $('.openReasonModal').click(function(e){
                e.preventDefault();
                var id = $(this).val();
                $('#id').val(id);
                $('#showReasonModal').modal('show');
            });
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="showReasonModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> --}}
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- @if(count($requests)) --}}
                    <form action="{{ route('approve_reject', $requests->id) }}" method="post">
                        <input type="hidden" id="id" name="reg_id" />
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
                    {{-- @endif --}}
                </div>

            </div>
        </div>
    </div>

</x-app-layout>