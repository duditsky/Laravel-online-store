@extends('layouts.default')

@section('title', 'Login')

@section('content')
<div class="container my-5">
    <div class="starter-template mb-4" style="text-align: center;">
        <h1>Login</h1>
    </div>
    
    <div class="row">
        <div class="col-md-6 offset-md-3 shadow-sm p-4 bg-white rounded border">

            <form action="{{ route('login.auth') }}" method="post">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" 
                           placeholder="Email" value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" 
                           placeholder="Password">
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-warning px-4 fw-bold">Login</button>
                    
                   <a href="{{ route('password.request') }}" class="text-decoration-none small fw-bold text-warning border-bottom border-warning">Forgot password?</a>
                </div>

                <hr class="my-4">
                
                <div class="text-center">
                    <span class="small">Don't have an account?</span>
                    <a href="{{ route('register.create') }}" class="small fw-bold text-decoration-none">Register here</a>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection