@extends('layouts.default')

@section('title','Form')

@section('content')
<div class="container my-5">
  <div class="starter-template" style="text-align: center;">
    <h1>Login</h1>
 </div>
    <div class="row">
      <div class="col-md-6 offset-md-3">

        <form action="{{route('login.auth')}}" method="post">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Email">
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
          </div>

          <button type="submit" class="btn btn-warning">Register</button>

        </form>

      </div>
    </div>

  </div>

  @endsection