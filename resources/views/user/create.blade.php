@extends('layouts.default')

@section('title','User Create')

@section('content')
<div class="container my-5">

    <h1>Register</h1>

    <div class="row">
        <div class="col-md-6 offset-md-3">

            <form action="{{route('register.store')}}" method="post">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-success">Register</button>

            </form>

        </div>
    </div>

</div>

@endsection