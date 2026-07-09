@extends('layouts.app')
@section('title', 'Forgot Password - AURA')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="text-center mb-2">Forgot Password</h3>
                    <p class="text-muted text-center mb-4">Please contact our support team for password reset assistance.</p>
                    <div class="text-center">
                        <a href="mailto:hello@aurasaree.com" class="btn btn-dark rounded-pill px-5">Contact Support</a>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
