@extends('components.layouts.auth')

@section('content')
    <div class="container">
        <div class="register-box">
            <div class="register-logo">
                <a href="{{ route('register') }}">{{ config('admin.appName', 'app.name') }}</a>
            </div>
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="register-box-msg">Register a new membership</p>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input id="name" type="name" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                placeholder="Full Name">
                            <div class="input-group-text">
                                <span class="bi bi-person"></span>
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email"
                                placeholder="Email">
                            <div class="input-group-text">
                                <span class="bi bi-envelope"></span>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" placeholder="Password">
                            <div class="input-group-text">
                                <span class="bi bi-lock-fill"></span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input id="password-confirm" type="password"
                                class="form-control @error('password-confirm') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            <div class="input-group-text">
                                <span class="bi bi-lock-fill"></span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        I agree to the <a href="#">terms</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if ( config('admin.sociallogin') )
                        <div class="social-auth-links text-center mb-3 d-grid gap-2">
                            <p>- OR -</p>
                            <a href="/auth/google/redirect" class="btn btn-danger">
                                <i class="bi bi-google me-2"></i> Sign in using Google+
                            </a>
                        </div>
                    @endif                       

                    <p class="mb-0">
                        <a href="{{ route('login') }}" class="text-center">
                            I already have a membership
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection