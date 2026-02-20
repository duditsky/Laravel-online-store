@extends('layouts.default')

@section('content')
<div class="container mt-4">
    <div class="row g-4">
        <div class="col-lg-9">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-sm bg-dark text-white" style="min-height: 400px; position: relative;">
                        <div class="container py-5">
                            @if($products->count() > 0)
                            <div id="productCarousel" class="carousel slide" data-bs-ride="false">
                                <div class="carousel-inner">
                                    @foreach($products->chunk(3) as $chunk)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <div class="row g-4 justify-content-center">
                                            @foreach($chunk as $product)
                                            <div class="col-md-4">
                                                <div class="position-relative overflow-hidden rounded-4 shadow-sm h-100 bg-white group">
                                                    <img src="{{ $product->image ? asset('storage/img/products/'.$product->image.'.jpg') : asset('img/no-image.png') }}"
                                                        class="img-fluid w-100 h-100 object-fit-contain p-3"
                                                        alt="{{ $product->name }}"
                                                        style="min-height: 200px; transition: transform 0.3s ease;">
                                                    <div class="position-absolute bottom-0 start-0 m-2">
                                                        <span class="badge bg-dark fs-6 px-3 py-2 shadow-sm" style="border-radius: 10px; opacity: 0.9;">
                                                            {{ $product->price }} ₴
                                                        </span>
                                                    </div>
                                                    <div class="position-absolute top-0 start-0 m-2 w-75">
                                                        <span class="badge bg-primary small fw-normal" style="font-size: 0.7rem;">
                                                            {{ $product->name }}
                                                        </span>
                                                    </div>
                                                    </a>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev" style="filter: invert(1); width: 5%;">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next" style="filter: invert(1); width: 5%;">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                            @else
                            <div class="text-center text-white">
                                <h3>No products found</h3>
                            </div>
                            @endif
                        </div>
                        <div class="card-img-overlay d-flex flex-column justify-content-center p-5" style="background: linear-gradient(90deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);">
                            <h1 class="display-4 fw-bold">Next-Gen Gaming <br><span class="text-primary">Laptops</span></h1>
                            <p class="lead w-50 d-none d-md-block">Experience ultimate performance with the newest RTX 50-series graphics cards.</p>
                            <div>
                                <a href="{{ route('allProducts') }}" class="btn btn-primary btn-lg px-4 fw-bold">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 mb-2 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold mb-0">Shop by Category</h4>
                    <a href="{{ route('categories') }}" class="text-primary text-decoration-none fw-bold small">View All ></a>
                </div>

                {{-- Приклад ітерації по категоріях (як у тебе в мега-меню) --}}
                @foreach($categories->take(6) as $category)
                <div class="col-md-4 col-6">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all text-center p-3 rounded-4">
                        <a href="{{ route('category', $category->code) }}" class="text-decoration-none text-dark">
                            <div class="mb-3">
                                <img src="{{ asset('storage/img/categories/' . $category->image . '.jpg') }}"
                                    class="img-fluid rounded" alt="{{ $category->name }}" style="height: 120px; object-fit: contain;">
                            </div>
                            <h6 class="fw-bold mb-1">{{ $category->name }}</h6>
                            <span class="text-muted small">Explore Gear</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-3">
            <div class="sticky-top" style="top: 100px;">

                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-primary text-white border-0 py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-lightning-fill"></i> Hot Deals</h5>
                    </div>
                    <div class="card-body p-0">
                        {{-- Тут можна вивести 3-4 акційних товари списком --}}
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-3 border-light">
                                <div class="d-flex align-items-center">
    <div class="flex-shrink-0 bg-light rounded p-1" style="width: 60px;">
        <img src="{{ asset('storage/img/products/4090.jpg') }}" class="img-fluid" alt="deal">
    </div>
    <div class="flex-grow-1 ms-3">
        <h6 class="small fw-bold mb-0">RTX 4090 OC Edition</h6>
        <div class="d-flex flex-column">
            <span class="text-muted small text-decoration-line-through" style="font-size: 0.75rem;">
                $1,599
            </span>
            <span class="text-danger fw-bold small">
                ${{ number_format(1599 * 0.8, 2) }}
            </span>
        </div>
    </div>
</div>
                            </li>
                            <li class="list-group-item p-3 border-light text-center bg-light">
                                <p class="small text-muted mb-2">Need professional advice?</p>
                                <button class="btn btn-sm btn-outline-dark w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#callbackModal">
                                    Ask an Expert
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card border-0 bg-info text-white rounded-4 shadow-sm p-4"
                    style="background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);">
                    <h5 class="fw-bold">Build Your PC</h5>
                    <p class="small opacity-75">Use our configurator to create your dream machine.</p>
                    <a href="#" class="btn btn-sm btn-light fw-bold text-primary">Start Building</a>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection