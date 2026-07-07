@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-vh-100 d-flex align-items-center" style="background: #f5f5f5;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <span class="fw-bold" style="font-family: 'Playfair Display', serif; font-size: 2rem; color: #1a1a1a;">AURA</span>
                    </a>
                    <p class="text-muted small mt-2">Welcome back to AURA</p>
                </div>

                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <h5 class="card-title text-center fw-bold mb-1">Sign In</h5>
                        <p class="text-center text-muted small mb-4">Enter your credentials to continue</p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label small fw-medium">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="far fa-envelope text-muted"></i></span>
                                    <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="you@example.com">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label small fw-medium">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                    <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="remember">Remember me</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="small text-decoration-none" href="{{ route('password.request') }}">Forgot Password?</a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-2 rounded-pill fw-medium">
                                Sign In <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="small text-muted mb-0">
                                Don't have an account?
                                <a href="{{ route('register') }}" class="text-decoration-none fw-medium">Register</a>
                            </p>
                        </div>
                    </div>
                </div>

                <p class="text-center text-muted small mt-4">
                    <a href="{{ route('home') }}" class="text-muted text-decoration-none"><i class="fas fa-chevron-left me-1"></i>Back to Home</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
