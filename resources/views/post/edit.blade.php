@extends('layouts.default')

@section('title','Post')

@section('content')
 <div class="container my-5">

   <h1>Edit</h1>

  <div class="row">
    <div class="col-md-6 offset-md-3">

         <form action="{{route('posts.update',$post->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="text" class="form-label">Text</label>
                <input type="text" name="text" class="form-control" id="text" placeholder="Post Text"  value="{{$post->text}}">
               
            </div>
           
           
            <button type="submit" class="btn btn-warning">Update</button>

         </form>

    </div> 
  </div>

 </div>

@endsection
