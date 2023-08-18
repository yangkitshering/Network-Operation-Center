<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Network Operation Center</title>

    <!-- CSS -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <x-app-layout>
            <x-slot name="header">

            </x-slot>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Small boxes (Stat box) -->
                                    <div class="row">
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-info">
                                                <div class="inner">
                                                    <?php
                                                    // Fetch registered users count from the database
                                                    $registeredUsersCount = DB::table('registrations')->count();
                                                    echo $registeredUsersCount;
                                                    ?>
                                                    <p>Total Request</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-person-add"></i>
                                                </div>
                                                <a href="approvedList" class="small-box-footer"><i
                                                        class="fas fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <!-- ./col -->
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <?php
                                                    // Fetch approved users count from the database
                                                    $approvedUsersCount = DB::table('registrations')->where('status', 'A')->count();
                                                    echo $approvedUsersCount;
                                                    ?>
                                                    <p>Approved</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-android-checkmark-circle"></i>
                                                </div>
                                                <a href="approvedList" class="small-box-footer"><i
                                                        class="fas fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <!-- ./col -->
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-warning">
                                                <div class="inner">
                                                    <?php
                                                    // Fetch pending users count from the database
                                                    $pendingUsersCount = DB::table('registrations')->where('status', 'I')->count();
                                                    echo $pendingUsersCount;
                                                    ?>
                                                    <p>Pending</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-android-time"></i>
                                                </div>
                                                <a href="pendingList" class="small-box-footer"> <i
                                                        class="fas fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <!-- ./col -->
                                        <div class="col-lg-3 col-6">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <?php
                                                    // Fetch rejected users count from the database
                                                    $rejectedUsersCount = DB::table('registrations')->where('status', 'R')->count();
                                                    echo $rejectedUsersCount;
                                                    ?>
                                                    <p>Rejected</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-backspace"></i>
                                                </div>
                                                <a href="approvedList" class="small-box-footer"> <i
                                                        class="fas fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div>
                                        <!-- ./col -->
                                    </div>
                                    <!-- /.row -->
                                    <!-- Main row -->
                                    <div class="row">
                                        <!-- Left col -->
                                        <div>
                                            <br>
                                            <p>
                                            <h2>Welcome to Our Network Operation Center (NOC) </h2>

                                            At Bhutan Telecom, we pride ourselves on providing cutting-edge
                                            Network Operation Center (NOC) solutions to businesses of all sizes.
                                            Our NOC is the nerve center of your network infrastructure, ensuring smooth
                                            operations, proactive monitoring, and rapid incident response. With our
                                            expert team and state-of-the-art technology, we guarantee exceptional
                                            network performance and uninterrupted connectivity.</p>


                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.container-fluid -->
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </x-app-layout>
    </div>


    <!-- JavaScript -->
    {{-- <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    {{-- <!-- <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script> --> --}}
    {{-- <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('dist/js/adminlte.js') }}"></script> --}}
    {{-- <script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script> --}}
    {{-- <script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script> --}}
    {{-- <!-- <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script> --> --}}
    {{-- <!-- <script src="{{ asset('dist/js/demo.js') }}"></script> --> --}}
    {{-- <!-- <script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script> --> --}}
    <!-- <script>
        // Monthly Chart Data
        var ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        var monthlyData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Approved',
                    data: [5, 3, 6, 4, 2, 7],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: false
                },
                {
                    label: 'Pending',
                    data: [2, 4, 1, 5, 3, 6],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: false
                },
                {
                    label: 'Rejected',
                    data: [2, 4, 5, 3, 6, 1],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: false
                }
            ]
        };
        var monthlyChart = new Chart(ctxMonthly, {
            type: 'line',
            data: monthlyData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart Data
        var ctxPie = document.getElementById('statusPieChart').getContext('2d');
        var pieData = {
            labels: ['Approved', 'Pending', 'Rejected'],
            datasets: [
                {
                    data: [53, 44, 65],
                    backgroundColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }
            ]
        };
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: pieData,
            options: {
                responsive: true
            }
        });
    </script> -->
</body>

</html>