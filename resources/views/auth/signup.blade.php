@extends('layouts.signup') <!-- Adjust to your layout file name -->

@section('title', 'Sign Up')

@section('content')
<div class="container">
    <div class="signup-container">
        <div class="signup-header">
        <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo-1.png') }}" alt="Example Image" style="width: 100px; height: auto;">
        </a>
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
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Silahkan masukan nama" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Silahkan masukan email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Silahkan masukan password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Password (Ulangi)</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Silahkan masukan password" required>
            </div>
            <button type="submit" class="btn btn-signup">Daftar</button>
            <div class="footer-text">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Log in</a></p>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background-color: #4d4d4d; /* Dark gray background */
    }
    .signup-container {
        background-color: #e0e0e0; /* Light gray container */
        max-width: 400px;
        margin: 100px auto;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }
    .signup-header {
        margin-bottom: 30px;
    }
    .logo {
        width: 80px;
        margin-bottom: 15px;
    }
    .brand-name {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333333; /* Dark text */
    }
    .brand-subtitle {
        font-size: 0.9rem;
        color: #666666; /* Subtle subtitle */
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }
    .form-label {
        font-weight: bold;
        color: #333333;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #cccccc;
        border-radius: 4px;
        font-size: 1rem;
    }
    .form-control:focus {
        outline: none;
        border-color: #ff704d; /* Orange accent */
        box-shadow: 0 0 5px rgba(255, 112, 77, 0.5);
    }
    .btn-signup {
        background-color: #ff704d; /* Orange button */
        color: #ffffff;
        font-size: 1rem;
        padding: 10px 15px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        width: 100%;
        font-weight: bold;
        text-transform: uppercase;
    }
    .btn-signup:hover {
        background-color: #e65c3a; /* Darker orange on hover */
    }
</style>
@endpush
