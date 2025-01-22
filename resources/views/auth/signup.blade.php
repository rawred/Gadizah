@extends('layouts.signup') <!-- Adjust to your layout file name -->

@section('title', 'Sign Up')

@section('content')
<div class="container">
    <div class="signup-container">
        <div class="signup-header">
            <h3>Create a New Account</h3>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('signup') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-signup">Sign Up</button>
        </form>
        <div class="footer-text">
            <p>Already have an account? <a href="{{ route('login') }}">Log in</a></p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .signup-container {
        max-width: 400px;
        margin: 100px auto;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .signup-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn-signup {
        width: 100%;
    }

    .footer-text {
        text-align: center;
        margin-top: 20px;
    }
</style>
@endpush
