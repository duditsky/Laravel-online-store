@extends('layouts.default')

@section('title', 'Reset Password')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 shadow-sm p-4 bg-white rounded border">
            <h2 class="text-center mb-4">Reset Password</h2>
            
            @if (session('status'))
                <div class="alert alert-success small">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="#">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" required placeholder="Enter your email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-bold">Send Reset Link</button>
            </form>
        </div>
    </div>
</div>
@endsection