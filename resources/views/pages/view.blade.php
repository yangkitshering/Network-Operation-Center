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

                    <style>
                        .card {
                            background-color: #f8fafc;
                            border-radius: 10px;
                            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
                            max-width: 800px;
                            margin: 0 auto;
                        }

                        .card-header {
                            background-color: #319d38;
                            border-bottom: none;
                            color: #fff;
                            font-size: 24px;
                            font-weight: bold;
                            padding: 20px;
                            text-align: center;
                        }

                        .card-body {
                            padding: 20px;
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }

                        th,
                        td {
                            padding: 12px;
                            text-align: left;
                            border-bottom: 1px solid #ddd;
                        }

                        th {

                            font-weight: bold;
                        }

                        .status-pending {
                            color: orange;
                            font-weight: bold;
                        }

                        .status-approved {
                            color: green;
                            font-weight: bold;
                        }
                    </style>

                    <div class="card">
                        <div class="card-header">User Request Details</div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $approvals->name }}</td>
                                </tr>
                                <tr>
                                    <th>Organization</th>
                                    <td>{{ $approvals->organization }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $approvals->email }}</td>
                                </tr>
                                <tr>
                                    <th>Contact</th>
                                    <td>{{ $approvals->contact }}</td>
                                </tr>
                                <tr>
                                    <th>rack Number</th>
                                    <td>{{ $approvals->rack_no }}</td>
                                </tr>
                                <tr>
                                    <th>rack Name</th>
                                    <td>{{ $approvals->rack_name }}</td>
                                </tr>
                                <tr>
                                    <th>reason</th>
                                    <td>{{ $approvals->reason }}</td>
                                </tr>
                                <tr>
                                    <th>Applied On</th>
                                    <td>{{ $approvals->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    @if($approvals->status == 'I')
                                    <td>{{'Pending'}}</td>
                                    @elseif ($approvals->status == 'A')
                                    <td>{{'Approved'}}</td>
                                    @else
                                    <td>{{'Rejected'}}</td>
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