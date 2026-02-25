@extends('layouts.default')

@section('title', 'Product Categories')

@section('content')
<div class="container py-5">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($categories as $category)
        <div class="col">
            <div class="card h-100 shadow-sm border-0 transition-hover" style="border-radius: 12px; overflow: hidden;">
                <a href="{{ route('category', $category->code) }}" class="text-decoration-none text-dark">
                    <div style="height: 250px; width: 100%; overflow: hidden; background-color: #f8f9fa;">
                        @php
                            $imagePath = $category->image 
                                ? asset('storage/img/categories/' . $category->image . '.jpg') 
                                : asset('img/no-image.png');
                        @endphp
                        
                        <img src="{{ $imagePath }}" 
                             class="w-100 h-100" 
                             style="object-fit: cover; object-position: center;" 
                             alt="{{ $category->name }}">
                    </div>

                    <div class="card-body text-center d-flex flex-column" style="min-height: 140px;">
                        <h2 class="card-title h5 mt-2" style="font-weight: 600; color: #333;">{{ $category->name }}</h2>
                        @if($category->description)
                        <p class="card-text text-muted flex-grow-1 px-2 small">
                            {{ Str::limit($category->description, 90) }}
                        </p>
                        @endif
                        <div class="mt-auto">
                            <span class="btn btn-outline-primary btn-sm rounded-pill px-4">View Category</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection