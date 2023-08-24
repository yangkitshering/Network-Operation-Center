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
                                {{ __('Tickets') }}
                            </h2>

                            {{-- <p class="mt-1 text-sm text-gray-600">
                                {{ __("List of approved requests") }}
                            </p> --}}

                        </header>
                        <br>

                        <table border="1" id="historyTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Ticket Name</th>
                                    <th>Ticket Details</th>
                                    <th>Organization</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{$ticket->ticketName}}</td>
                                    <td>{{$ticket->ticket}}</td>
                                    <td>{{$ticket->org_name}}</td>
                                    @if($ticket->status == 0)
                                    <td>{{'Not Closed'}}</td>
                                    @else
                                    <td>{{'Closed'}}</td>
                                    @endif

                                    <td>
                                        @if($ticket->status == 0)
                                        <form action="closeTicket/{{ $ticket->id }}" method="post">

                                            <a href="ticketView/{{ $ticket->id }}" class="btn btn-info btn-sm">
                                                <i class="far fa-edit"></i>
                                                &#x1F441;View</a>

                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" value="0" name='flag'>
                                                <i class="far fa-trash-alt"></i>
                                                &#x2718;Close</button>
                                        </form>
                                        @else
                                        <a href="ticketView/{{ $ticket->id }}" class="btn btn-info btn-sm">
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
                    
                            });
                        </script>

                    </section>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>