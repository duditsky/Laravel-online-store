@extends('layouts.default')

@section('title', 'Product Categories')

@section('content')
<div class="container py-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($categories as $category)
        <div class="col">
            <div class="card h-100 shadow-sm border-0 transition-hover" style="border-radius: 12px; overflow: hidden;">
                <a href="{{ route('category', $category->code) }}" class="text-decoration-none text-dark">
                    <div style="height: 220px; overflow: hidden; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; padding: 15px;">
                        @if($category->image)
                        <img src="{{ asset('storage/img/categories/' . $category->image . '.jpg') }}"
                            class="img-fluid h-100 w-auto"
                            style="object-fit: contain;"
                            alt="{{ $category->name }}">
                        @else
                        <img src="{{ asset('img/no-image.png') }}"
                            class="img-fluid h-100 w-auto"
                            style="object-fit: contain;"
                            alt="No image">
                        @endif
                    </div>

                    <div class="card-body text-center d-flex flex-column">
                        <h2 class="card-title h5 mt-2" style="font-weight: 600; color: #333;">{{ $category->name }}</h2>
                        @if($category->description)
                        <p class="card-text text-muted flex-grow-1 px-2 small">
                            {{ Str::limit($category->description, 90) }}
                        </p>
                        @endif
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>


@endsection