@extends('layouts.app')
@section('title', 'Forgot Password - AURA')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="text-center mb-2">Forgot Password</h3>
                    <p class="text-muted text-center mb-4">Enter your email to reset your password.</p>
                    <form method="POST" action="{{ route('password.request') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 btn-lg rounded-pill">Send Reset Link</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
