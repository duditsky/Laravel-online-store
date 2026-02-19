@extends('layouts.default')

@section('title', 'Product Categories')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5" style="font-weight: 700; color: #2c3e50; text-transform: uppercase; letter-spacing: 2px;">
        Browse Categories
    </h1>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($categories as $category)
        <div class="col">
            <div class="card h-100 shadow-sm border-0 transition-hover" style="border-radius: 12px; overflow: hidden;">
                <a href="/categories/{{$category->code}}" class="text-decoration-none text-dark">
                    <div style="height: 220px; overflow: hidden; background-color: #f8f9fa;">
                        {{-- Using your structure for images --}}
                        <img src="{{ url('img/'.$category->image.'.jpg') }}" 
                             class="card-img-top w-100 h-100" 
                             style="object-fit: cover;" 
                             alt="{{ $category->name }}">
                    </div>
                    
                    <div class="card-body text-center d-flex flex-column">
                        <h2 class="card-title h4 mt-2" style="font-weight: 600;">{{ $category->name }}</h2>
                        <p class="card-text text-muted flex-grow-1 px-2">
                            {{ Str::limit($category->description, 90) }}
                        </p>
                    </div>
                </a>
                <div class="card-footer bg-white border-0 pb-4 text-center">
                    <a href="/categories/{{$category->code}}" class="btn btn-dark px-4 py-2 shadow-sm" style="border-radius: 5px; font-weight: 500;">
                        VIEW PRODUCTS
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


@endsection