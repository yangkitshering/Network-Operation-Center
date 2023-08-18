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


                                            <button type="submit" class="btn btn-danger btn-sm delete-confirm" value="0"
                                                name='flag'>
                                                <i class="far fa-trash-alt"></i>
                                                &#x2718;Reject</button>

                                            {{-- @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-confirm ml-1">
                                                <i class="far fa-trash-alt"></i>
                                                Delete</button> --}}

                                            {{-- <a href="view-user/{{ $user->id }}" class="btn btn-info btn-sm">
                                                <i class="far fa-edit"></i>
                                                &#x1F441;View</a> --}}
                                        </form>

                                    </td>
                                    @endif
                                </tr>
                                @endforeach

                            </tbody>
                            @else
                            <tbody>
                                <tr>
                                    <td colspan="9" align="center">No Users</td>
                                </tr>
                            </tbody>
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

</x-app-layout>