@extends('layouts.default')
@section('title', 'Categories')
@section('content')
<div class="container">
  <div class="starter-template" style="text-align: center;">
    @foreach ($categories as $category)
    <div class="panel">
      <a href="/categories/{{$category->code}}">
        <img src="{{url('img/'.$category->image.'.jpg')}}" alt="" width="300px">
        <h2>{{$category->name}}</h2>
      </a>
      <p>{{$category->description}}</p>
    </div>
    @endforeach
  </div>
</div>
@endsection