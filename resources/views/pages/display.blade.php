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
                <th>Mail Title</th>
                <th>Mail Body</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

            @foreach($approvals as $approval)
            <tr>
                <td>{{$approval->title}}</td>
                <td>{{$approval->body}}</td>
                @if($approval->status == 0)
                <td>{{'Pending'}}</td>
                @else
                <td>{{'Approved'}}</td>
                @endif

                <td>
                    <form action="approval_mail/{{ $approval->id }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm delete-confirm" value="1" name='flag'>
                            <i class="far fa-edit"></i>
                            Approve</button>

                        <button type="submit" class="btn btn-danger btn-sm delete-confirm" value="0" name='flag'>
                            <i class="far fa-trash-alt"></i>
                            Reject</button>
                    </form>


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