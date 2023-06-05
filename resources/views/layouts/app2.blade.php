<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Network Operation Center') }}</title>

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/gif" sizes="16x16">

    <link rel="stylesheet" href="{{ asset('css/app1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slider.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.0/css/ionicons.min.css">
</head>

<body>
    <section class="top-bar animated-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="/">
                            <img src="../images/logo.png" alt="logo" width="70">
                            <span class="pl-3 cd-headline">Network Operation Center</span>
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    {{-- <a class="nav-link" href="{{ route('register') }}">{{ __('Request Approval')
                                        }}</a> --}}
                                    <a href="#" class="nav-link" data-toggle="modal" data-target="#approveFormModal">
                                        Request Register
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="footer">
        <div class="container">
            <div class="row content-justify-between">
                <div class="col-md-8 col-12 text-center text-lg-left text-md-left">
                    <p class="copyright">Copyright © Bhutan Telecom Limited
                        <?php echo date("Y"); ?>.<br>
                    </p>
                </div>

            </div>
        </div>
    </footer>
    <!-- /#footer -->

    <!-- Javascript Files -->
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('js/sweetalert2.js') }}" defer></script> --}}
    <script src="{{ asset('js/slider.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Success',
                                text: '{{ session('success') }}',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        });
    </script>
    @endif

    <script>
        function clearFormFields() {
            document.getElementById("approvalForm").reset();
            // windows.location.href = "/";
        }
    </script>

    {{-- Modal --}}
    <div class="modal fade" id="approveFormModal" tabindex="-1" role="dialog" aria-labelledby="approveFormModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="text-align: center" id="approveFormModalLabel">Request Registration
                        Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="clearFormFields()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('save_request') }}" method="post" id="approvalForm">

                        {{ csrf_field() }}
                        {{-- <div class="form-row"> --}}
                            <div class="form-group col-md-12">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your name" required>
                                <span style="color:red">
                                    @error('name')
                                    {{ $message}}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your valid email that you will be notified" required>
                            </div>

                            {{-- <div class="form-group">
                                <label for="email">To Email</label>
                                <input type="email" class="form-control" id="email" name="toemail"
                                    placeholder="Enter your email" required>
                            </div> --}}
                            <div class="form-group col-md-12">
                                <label for="contact">Contact No</label>
                                <input type="tel" class="form-control" id="contact" name="contact"
                                    placeholder="Enter your contact number" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="organization">Organization Name</label>
                                <input type="text" class="form-control" id="organization" name="organization"
                                    placeholder="Enter your organization name" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="rack">Rack No</label>


                                <select class="form-control" id="rack" name="rack" required>
                                    <option value="" disabled selected>Select a rack number</option>
                                    @foreach($rackList as $rack)

                                    <option value="{{ $rack->id}}">{{ $rack->rack_no}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="reason">Reason</label>
                                <textarea class="form-control" type="text" id="reason" name="reason" rows="4" cols="50"
                                    placeholder="Kindly provide details on why you wanted to have access to server room "></textarea>
                                {{-- <input type="text" class="form-control" id="reason" name="reason"
                                    placeholder="Enter your reason" required> --}}
                            </div>
                            {{-- <div class="form-group col-md-4"> --}}
                                <button type="submit" class="form-control btn-info" id="submitBtn">Submit</button>
                                {{--
                            </div> --}}
                            {{--
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function clearFormFields() {
        document.getElementById("approvalForm").reset();
    }
    </script>

</body>

</html>