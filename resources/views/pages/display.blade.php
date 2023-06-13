<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 text-center">
            {{ __('Pending Approval Request') }}
        </h2>

        {{-- <p class="mt-1 text-sm text-gray-600">
            {{ __("List of approved requests") }}
        </p> --}}

    </header>
    <br>

    <table border="1" id="historyTable" class="table table-bordered table-striped">
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
                @if($res->status == 'I')
                <td>{{'Pending'}}</td>
                @elseif ($res->status == 'A')
                <td>{{'Approved'}}</td>
                @else
                <td>{{'Rejected'}}</td>
                @endif

                <td>
                    @if(Auth::user()->hasRole('admin'))
                    @if($res->status == 'I')
                    <form action="process_request/{{ $res->id }}" method="post">

                        <a href="view-request/{{ $res->id }}" class="btn btn-info btn-sm">
                            <i class="far fa-edit"></i>
                            &#x1F441;View</a>

                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm" value="1" name='flag'>
                            <i class="far fa-edit"></i>
                            &#x2705; Approve</button>

                        <button type="submit" class="btn btn-danger btn-sm delete-confirm" value="0" name='flag'>
                            <i class="far fa-trash-alt"></i>
                            &#x2718;Reject</button>
                    </form>
                    @else
                    <a href="view-request/{{ $res->id }}" class="btn btn-info btn-sm">
                        <i class="far fa-edit"></i>
                        &#x1F441;View</a>

                    @endif
                    @else
                    <a href="view-request/{{ $res->id }}" class="btn btn-info btn-sm">
                        <i class="far fa-edit"></i>
                        &#x1F441;View</a>

                    @endif
                </td>
            </tr>
            @endforeach

        </tbody>

    </table>

    <script>
        $('#historyTable').DataTable({
            // "buttons": [
            //     { extend: 'excel', 
            //     text: '<i class="fas fa-file-pdf fa-1x" aria-hidden="true"> Export as excel</i>',
            //     title: 'Recharge history'
            // }
            // ]
            
    
        });
        // .buttons().container().appendTo('#example1_wrapper');

    </script>

</section>