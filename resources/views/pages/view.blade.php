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
                        <div class="card-header">User Request Details</div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $requests->name }}</td>
                                </tr>
                                <tr>
                                    <th>CID</th>
                                    <td>{{ $requests->cid }}</td>
                                </tr>
                                <tr>
                                    <th>Organization</th>
                                    <td>{{ $requests->organization }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $requests->email }}</td>
                                </tr>
                                <tr>
                                    <th>Contact</th>
                                    <td>{{ $requests->contact }}</td>
                                </tr>
                                <tr>
                                    <th>rack Number</th>
                                    <td>{{ $requests->rack_no }}</td>
                                </tr>
                                <tr>
                                    <th>rack Name</th>
                                    <td>{{ $requests->rack_name }}</td>
                                </tr>
                                <tr>
                                    <th>reason</th>
                                    <td>{{ $requests->reason }}</td>
                                </tr>
                                <tr>
                                    <th>Visit From</th>
                                    <td>{{ $requests->visitFrom }}</td>
                                </tr>
                                <tr>
                                    <th>Visit To</th>
                                    <td>{{ $requests->visitTo }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    @if($requests->status == 'I')
                                    <td>{{'Pending'}}</td>
                                    @elseif ($requests->status == 'A')
                                    <td>{{'Approved'}}</td>
                                    @else
                                    <td>{{'Rejected'}}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>Exited</th>
                                    @if($requests->exited == 0)
                                    <td>{{'No'}}</td>
                                    @else
                                    <td>{{'Yes'}}</td>
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