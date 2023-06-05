<section>
    {{-- <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Recorded Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("List of approved requests") }}
        </p>

    </header> --}}

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

            @foreach($approvals as $approval)
            <tr>
                <td>{{$approval->organization}}</td>
                <td>{{$approval->rack_name}}</td>
                <td>{{$approval->reason}}</td>
                @if($approval->status == 'I')
                <td>{{'Pending'}}</td>
                @elseif ($approval->status == 'A')
                <td>{{'Approved'}}</td>
                @else
                <td>{{'Rejected'}}</td>
                @endif

                <td>
                    @if($approval->status == 'I')
                    <form action="approval_mail/{{ $approval->id }}" method="post">
                        @csrf
                        @method('PUT')

                        <button type="submit" class="btn btn-info btn-sm delete-confirm" value="2" name='flag'>
                            <i class="far fa-edit"></i>
                            &#x1F441;View</button>

                        <button type="submit" class="btn btn-success btn-sm" value="1" name='flag'>
                            <i class="far fa-edit"></i>
                            &#x2705; Approve</button>

                        <button type="submit" class="btn btn-danger btn-sm delete-confirm" value="0" name='flag'>
                            <i class="far fa-trash-alt"></i>
                            &#x2718;Reject</button>
                    </form>
                    @else
                    <form action="approval_mail/{{ $approval->id }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-info btn-sm delete-confirm" value="2" name='flag'>
                            <i class="far fa-edit"></i>
                            &#x1F441;View</button>
                    </form>
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