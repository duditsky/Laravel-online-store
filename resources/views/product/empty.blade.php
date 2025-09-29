@extends('layouts.default')
@section('title', 'Basket')
@section('content')
<div class="container">
    <div class="starter-template" style="text-align: center;">
        <br>
         <br>
          <br>
           <br>
            <br>
             <br>
              <br>
               <br>
        <h1>Your Basket is Empty!</h1>
       <br>
        <a href="{{route('home')}}" class="btn btn-primary" role="button">To Home Page</a>
    </div>
</div>
@endsection