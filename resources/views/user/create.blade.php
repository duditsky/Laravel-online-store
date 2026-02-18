@extends('layouts.default')

@section('title','User Create')

@section('content')
<div class="container my-5">

    <h1 class="text-center mb-4">Register</h1>

    <div class="row">
        <div class="col-md-6 offset-md-3 shadow-sm p-4 bg-white rounded border">

            <form action="{{route('register.store')}}" method="post">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="name" placeholder="Name" value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" placeholder="Email" value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        id="password" placeholder="Password">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        id="password_confirmation" placeholder="Confirm Password">
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-success px-4">Register</button>
                </div>

                <hr class="my-4">
                <div class="text-center">
                    <span class="small">Already have an account?</span>
                    <a href="{{ route('login') }}" class="small fw-bold text-decoration-none">Login here</a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection