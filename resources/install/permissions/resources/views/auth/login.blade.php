@extends('components.layouts.auth')

@section('content')
    <div class="container">
        <div class="card card-outline card-primary login-box">
            <div class="login-logo card-header text-center">
                {{ config('admin.appName', 'app.name') }}
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="login" type="text" class="form-control @error('login') is-invalid @enderror"
                            name="login" value="{{ old('login') }}" required autocomplete="login" autofocus
                            placeholder="Username or Email">
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                        @error('login')
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

                    <div class="row justify-contents-center">
                        <div class="col-8">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="remember"
                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                            </div>
                        </div>
                    </div>
                </form>

                @if (config('admin.sociallogin'))
                    <div class="social-auth-links text-center mb-3 d-grid gap-2">
                        <p>- OR -</p>
                        <a href="/auth/google/redirect" class="btn btn-danger">
                            <i class="bi bi-google me-2"></i> Sign in using Google+
                        </a>
                    </div>
                @endif

                <p class="mb-1">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </p>
                <p class="mb-0">
                    @if (Route::has('register'))
                        <a class="btn btn-link" href="{{ route('register') }}">
                            {{ __('Register a new membership?') }}
                        </a>
                    @endif
                </p>
            </div>
        </div>
    </div>
@endsection
