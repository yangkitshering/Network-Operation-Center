<x-app-layout>
    <x-slot name="header">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 text-center">
                                    {{ __('Data Center') }}
                                </h2>
                            </header>
                            <br>

                            <div class="input-group">
                                <a href="/add_dc">
                                    <button type="button" class="btn btn-info" style="font-size: 13">
                                        <i class="fas fa-user-plus"></i>
                                        Add DC
                                    </button>
                                </a>
                            </div>
                            <br>
                            <table border="1" id="manage_user" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>UID</th>
                                        <th>DC Name</th>
                                        <th>DC Location</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($dataCenters as $dataCenter)
                                    <tr>
                                        <td>{{ $dataCenter->id }}</td>
                                        <td>{{ $dataCenter->dc_name }}</td>
                                        <td>{{ $dataCenter->dc_location }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </section>
                        <br>
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 text-center">
                                    {{ __('Client') }}
                                </h2>
                            </header>
                            <br>

                            <div class="input-group">
                                <a href="{{ route('add_organization')}}">
                                    <button type="submit" class="btn btn-info" style="font-size: 13">
                                        <i class="fas fa-user-plus"></i>
                                        Add Client
                                    </button>
                                </a>
                            </div>
                            <br>
                            <table border="1" id="manage_user" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>UID</th>
                                        <th>Organization Name</th>
                                        <th>Organization Address</th>
                                        <th>Data Center</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($org_list as $org)
                                    <tr>
                                        <td>{{ $org->id }}</td>
                                        <td>{{ $org->org_name }}</td>
                                        <td>{{ $org->org_address }}</td>
                                        <td>{{ $org->dc_name}}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </section>
                        <br>
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 text-center">
                                    {{ __('Rack') }}
                                </h2>
                            </header>
                            <br>

                            <div class="input-group">
                                <a href="{{ route('add_racklist')}}">
                                    <button type="submit" class="btn btn-info" style="font-size: 13">
                                        <i class="fas fa-user-plus"></i>
                                        Add Rack
                                    </button>
                                </a>
                            </div>
                            <br>
                            <table border="1" id="manage_user" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>UID</th>
                                        <th>Rack Number</th>
                                        <th>Rack Name</th>
                                        <th>Rack Description</th>
                                        <th>Organization Name</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($rack_list as $rack)
                                    <tr>
                                        <td>{{ $rack->id }}</td>
                                        <td>{{ $rack->rack_no }}</td>
                                        <td>{{ $rack->rack_name }}</td>
                                        <td>{{ $rack->desc }}</td>
                                        <td>{{ $rack->org_name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </section>
                        <br>
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 text-center">
                                    {{ __('DC NOC Focal') }}
                                </h2>
                            </header>
                            <br>

                            <div class="input-group">
                                <a href="{{ route('add_focal')}}">
                                    <button type="submit" class="btn btn-info" style="font-size: 13">
                                        <i class="fas fa-user-plus"></i>
                                        Add NOC Focal
                                    </button>
                                </a>
                            </div>
                            <br>
                            <table border="1" id="manage_user" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>UID</th>
                                        <th>Focal Person Name</th>
                                        <th>Focal Person Contact</th>
                                        <th>Focal Person DC</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($focal_list as $focal)
                                    <tr>
                                        <td>{{ $focal->id }}</td>
                                        <td>{{ $focal->focal_name }}</td>
                                        <td>{{ $focal->focal_contact }}</td>
                                        <td>{{ $focal->dc_name }}</td>
                                        {{-- <td>{{ $rack->org_name }}</td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>