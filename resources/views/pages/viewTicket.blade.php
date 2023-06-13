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

                    <div class="card">
                        <div class="card-header">Ticket Details</div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <th>Ticket Name</th>
                                    <td>{{ $ticket->ticketName }}</td>
                                </tr>
                                <tr>
                                    <th>Ticket Description</th>
                                    <td>{{ $ticket->ticket }}</td>
                                </tr>
                                <tr>
                                    <th>Ticket Raised By</th>
                                    <td>{{ $ticket->name }}</td>
                                </tr>
                                <tr>
                                    <th>Organization</th>
                                    <td>{{ $ticket->organization }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $ticket->email }}</td>
                                </tr>
                                <tr>
                                    <th>Contact</th>
                                    <td>{{ $ticket->contact }}</td>
                                </tr>
                                <tr>
                                    <th>Ticket Raised On</th>
                                    <td>{{ $ticket->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Ticket Status</th>
                                    @if($ticket->status == 0)
                                    <td>{{'Not Closed'}}</td>
                                    @else
                                    <td>{{'Closed'}}</td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>