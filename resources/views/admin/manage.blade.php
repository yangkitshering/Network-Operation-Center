<x-app-layout>
    <x-slot name="header">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 text-center">
                                    {{ __('User list') }}
                                </h2>
                            </header>
                            <br>

                            <div class="input-group">
                                <a href="{{ route('add_user')}}">
                                    <button type="submit" class="btn btn-info" style="font-size: 13">
                                        <i class="fas fa-user-plus"></i>
                                        Add User
                                    </button>
                                </a>
                            </div>
                            <br>
                            <table border="1" id="manage_user" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>UID</th>
                                        <th>Name</th>
                                        <th>Organization</th>
                                        <th>Email Address</th>
                                        {{-- <th>Role</th> --}}
                                        <th>Approved</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                @if(count($users))
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        @if($user->role == 'admin')
                                        <td>{{'BTL DataCenter'}}</td>
                                        @elseif($user->role == 'user' && $user->is_dcfocal == 1)
                                        <td>{{'BTL'}}</td>
                                        @else
                                        <td>{{$user->org_name}}</td>
                                        @endif
                                        <td>{{$user->email}}</td>
                                        {{-- <td>
                                            @if($user->role == 'admin')
                                            {{ 'Admin' }}
                                            @else
                                            {{ 'User' }}
                                            @endif
                                        </td> --}}
                                        <td>
                                            @if($user->verified == 0)
                                            {{ 'No' }}
                                            @else
                                            {{ 'Yes' }}
                                            @endif
                                        </td>

                                        <td>
                                            @if(Auth::user()->hasRole('admin'))
                                            @if ($user->id == auth()->user()->id)
                                            <p>Current Admin</p>
                                            @else
                                            <form action="manage_users/{{ $user->id }}" method="post">

                                                <a href="manage_users/{{ $user->id }}" class="btn btn-success btn-sm">
                                                    <i class="far fa-edit"></i>
                                                    Edit</a>

                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete-confirm ml-1"
                                                    name="flag" value="1">
                                                    <i class="far fa-trash-alt"></i>
                                                    Delete</button>

                                            </form>
                                            @endif
                                            @else
                                            @if ($user->id == auth()->user()->id)
                                            <p>Current Admin</p>
                                            @else
                                            <form action="manage_users/delete_adduser/{{ $user->id }}" method="post">
                                                @if($user->verified == 0)
                                                <a href="manage_users/add_user/{{ $user->id }}"
                                                    class="btn btn-success btn-sm">
                                                    <i class="far fa-edit"></i>
                                                    Edit</a>
                                                @endif

                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete-confirm ml-1"
                                                    name="flag" value="2">
                                                    <i class="far fa-trash-alt"></i>
                                                    Delete</button>
                                            </form>
                                            @endif
                                            @endif
                                        </td>

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
                        </section>
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>