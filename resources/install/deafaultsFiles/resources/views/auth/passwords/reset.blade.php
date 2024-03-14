@extends('components.layouts.auth')

@section('content')
    <div class="container">
        <div class="card card-outline card-primary login-box">
            <div class="login-logo card-header text-center">
                {{ __('Reset Password') }}
            </div>
            <div class="card-body login-card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="input-group mb-3">
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                        <div class="input-group-text">
                            <span class="bi-envelope"></span>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password" placeholder="Password">
                        <div class="input-group-text">
                            <span class="bi-lock-fill"></span>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input id="password-confirm" type="password"
                            class="form-control @error('password-confirm') is-invalid @enderror"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                        <div class="input-group-text">
                            <span class="bi-lock-fill"></span>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
