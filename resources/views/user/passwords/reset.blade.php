@extends('layouts.default')
@section('title', 'Set New Password')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 shadow-sm p-4 bg-white rounded border">
            <h2 class="text-center mb-4">New Password</h2>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-bold">Update Password</button>
            </form>
        </div>
    </div>
</div>
@endsection