@extends('layouts.app2')

@section('content')
<section id="hero-area-login">
    <section class="vh-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="text-align: center">{{ __('Fill in your feedback') }}</div>

                        <div class="card-body">

                            @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                            @endif

                            <form action="{{ route('save-feedback') }}" method="post" id="feedback">
                                @csrf
                                {{-- <div class="form-row"> --}}
                                    <div class="form-group col-md-10">
                                        <label for="name" required>Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter your name" required>

                                    </div>
                                    <div class="form-group col-md-10">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter your email" required>
                                    </div>

                                    <div class="form-group col-md-10">
                                        <label for="contact">Contact No</label>
                                        <input type="tel" class="form-control" id="contact" name="contact"
                                            placeholder="Enter your contact number" required>
                                    </div>

                                    <div class="form-group col-md-10">
                                        <label for="feedback">Your Feedback</label>
                                        <textarea class="form-control" type="text" id="feedback" name="feedback"
                                            rows="4" cols="50" placeholder="Kindly provide your feedback"></textarea>
                                        {{-- <input type="text" class="form-control" id="reason" name="reason"
                                            placeholder="Enter your reason" required> --}}
                                    </div>
                                    {{-- <div class="form-group col-md-4"> --}}
                                        <button type="submit" class="form-control btn-info" id="submitBtn">Send</button>
                                        {{--
                                    </div> --}}
                                    {{--
                                </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

@endsection