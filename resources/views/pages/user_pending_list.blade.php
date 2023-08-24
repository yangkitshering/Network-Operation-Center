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
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 text-center">
                                {{ __('User pending approval list') }}
                            </h2>
                        </header>

                        <br>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <!-- jQuery -->
                        <script src="{{ asset('js/jquery.min.js') }}"></script>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
                            rel="stylesheet">
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js">
                        </script>

                        <table border="1" id="user-pending" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>UID</th>
                                    <th>Name</th>
                                    <th>Organization</th>
                                    <th>Email Address</th>
                                    {{-- <th>Role</th> --}}
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            @if(count($users))
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->org_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @if($user->verified == 0)
                                        {{ 'Pending' }}
                                        @else
                                        {{ 'Approved' }}
                                        @endif
                                    </td>

                                    @if(Auth::user()->hasRole('admin'))
                                    <td>
                                        <form action="user_action/{{ $user->id }}" method="post">

                                            <a href="user_pending/{{ $user->id }}" class="btn btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                                View</a>

                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" value="1" name='flag'>
                                                <i class="far fa-edit"></i>
                                                &#x2705; Approve</button>


                                            <button type="button" class="btn btn-danger btn-sm delete-confirm openModal"
                                                id="openModal" value="{{$user->id}}">
                                                <i class="far fa-trash-alt"></i>
                                                &#x2718;Reject</button>

                                            {{-- <button type="button" class="btn btn-info btn-sm" id="openModel">
                                                <i class="far fa-edit"></i>
                                                &#x1F441;Open model</button> --}}
                                        </form>

                                    </td>
                                    @endif
                                </tr>
                                @endforeach

                            </tbody>
                            @else
                            <tbody>
                                <tr>
                                    <td colspan="9" allign="center">No Users</td>
                                </tr>
                            </tbody>
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
                                            window.location.href = "{{ route('user-pending')}}";
                                        }
                                    });
                        });
                        </script>
                        @endif

                    </section>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready( function(){
            $('.openModal').click(function(e){
                e.preventDefault();
                var id = $(this).val();
                $('#id').val(id);
                $('#showModal').modal('show');
            });
        });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> --}}
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(count($users))
                    <form action="user_pending/{{ $user->id }}" method="post">
                        <input type="hidden" id="id" name="user_id" />
                        <div class="form-group col-md-12">
                            <label for="organization">State reject reason</label>
                            <textarea type="text" class="form-control" id="reject" name="rejectReason"
                                placeholder="Please state your reject reason" required></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            @csrf
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