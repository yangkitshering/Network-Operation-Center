@extends('layouts.navbar')

@section('content')
<div class="container">
    {{-- <div class="container d-flex justify-content-center mt-100"> --}}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{-- <h2 class="">Recharge History</h2> --}}
                    {{-- <select name="packages" class="form-control">
                        <option>Select Packages to view</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select> --}}

                    <table border="1" id="historyTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Package</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                        
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2021-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2022-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2020-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2022-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2022-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2022-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2022-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2022-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2022-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2022-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2022-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2022-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2022-10-28</td>
                                <td>Failed</td>
                            </tr>
                            <tr>
                                <td>17455829</td>
                                <td>2</td>
                                <td>2022-10-28</td>
                                <td>Failed</td>
                            </tr>
                        </tbody>

                    </table>
                    <div id="example1_wrapper"></div>
                </div>
            </div>
        </div>
        {{--
    </div> --}}
</div>

<script>
    $('#historyTable').DataTable({
        "buttons": [
            { extend: 'excel', 
            text: '<i class="fas fa-file-pdf fa-1x" aria-hidden="true"> Export as excel</i>',
            title: 'Recharge history'
        }
        ]

    }).buttons().container().appendTo('#example1_wrapper');
</script>

@endsection

@push('scripts')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- DataTables js and css -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<!-- DataTables  & Plugins alternate-->
{{--
<link rel="stylesheet" href="{{ asset('../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

<script src="{{ asset('../../plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('../../plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script> --}}

<!-- DataTables buttons for excel, pdf etc. -->
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('../plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

@endpush
@stack('scripts')