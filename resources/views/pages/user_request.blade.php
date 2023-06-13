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
                                {{ __('Your Request') }}
                            </h2>
                        </header>
                        <br>

                        <table border="1" id="approved_rejectList" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Organization Name</th>
                                    <th>Rack Name</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($requests as $res)
                                <tr>
                                    <td>{{$res->organization}}</td>
                                    <td>{{$res->rack_name}}</td>
                                    <td>{{$res->reason}}</td>
                                    @if ($res->status == 'A')
                                    <td>{{'Approved'}}</td>
                                    @elseif($res->status == 'I')
                                    <td>{{'Pending'}}</td>
                                    @else
                                    <td>{{'Rejected'}}</td>
                                    @endif

                                    <td>
                                        <a href="view-request/{{ $res->id }}" class="btn btn-info btn-sm">
                                            <i class="far fa-edit"></i>
                                            &#x1F441;View</a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>

                        </table>

                        <script>
                            $('#approved_rejectList').DataTable({
                                
                            });
                        </script>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>