@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="wrap">
                <div class="img" style="background-image: url('images/BT.png');"></div>
                <!-- <img src="images/BT.png" alt="" width="350"> -->
                <div class="index-title">NOC</div>
                <div class=" login-wrap p-4 p-md-3 mt-3 mx-3">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                            <label class="form-control-placeholder" for="email">{{ __('Email
                                Address or Employee ID') }}</label>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
                            <label class="form-control-placeholder" for="password">{{ __('Password') }}</label>

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div style="text-align: center; font-size: 13px">
                                <a href="{{ route('register') }}">{{ __('Register ?') }}</a>
                                <button type="submit" class="btn btn-primary rounded submit px-3">Login</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div style="text-align: center; font-size: 13px">
                                <a href="{{ route('password.request') }}">{{ __('Forgot Password') }}</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection