@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-vh-100 d-flex align-items-center" style="background: #f5f5f5;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <span class="fw-bold" style="font-family: 'Playfair Display', serif; font-size: 2rem; color: #1a1a1a;">AURA</span>
                    </a>
                    <p class="text-muted small mt-2">Create your AURA account</p>
                </div>

                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4 p-lg-5">
                        <h5 class="card-title text-center fw-bold mb-1">Create Account</h5>
                        <p class="text-center text-muted small mb-4">Fill in your details to get started</p>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label small fw-medium">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="far fa-user text-muted"></i></span>
                                    <input id="name" type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Your full name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label small fw-medium">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="far fa-envelope text-muted"></i></span>
                                    <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@example.com">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label small fw-medium">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                                    <input id="phone" type="tel" class="form-control border-start-0 @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required placeholder="+91 98765 43210">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label small fw-medium">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                        <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password-confirm" class="form-label small fw-medium">Confirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-check-circle text-muted"></i></span>
                                        <input id="password-confirm" type="password" class="form-control border-start-0" name="password_confirmation" required autocomplete="new-password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                <label class="form-check-label small" for="terms">
                                    I agree to the <a href="{{ route('terms') }}" class="text-decoration-none">Terms & Conditions</a> and <a href="{{ route('privacy') }}" class="text-decoration-none">Privacy Policy</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-2 rounded-pill fw-medium">
                                Create Account <i class="fas fa-user-plus ms-2"></i>
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="small text-muted mb-0">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-decoration-none fw-medium">Sign In</a>
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
