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
                                {{ __('Approved/Rejected Request') }}
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
                        <div id="excel_button_wrapper"></div>

                        <!-- DataTables buttons for excel, pdf etc. -->
                        <script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
                        <script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
                        <script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
                        <script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
                        <script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
                        <script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
                        <script src="{{asset('../plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

                        <script>
                            $('#approved_rejectList').DataTable({
                                "buttons": [
                                { extend: 'excel', 
                                text: '<i class="btn btn-success btn-sm" aria-hidden="true"> Export as excel</i>',
                                title: 'Request List'
                                }]
                            }).buttons().container().appendTo('#excel_button_wrapper');
                    
                        </script>

                    </section>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>