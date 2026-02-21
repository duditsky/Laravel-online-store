@extends('layouts.default')

@section('content')
<div class="container mt-4">
    <div class="row g-4">
        <div class="col-lg-9">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-sm bg-black text-white" style="min-height: 400px; position: relative;">
        
                            <div style="
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 100%;
                                    background-image: url('{{ asset('storage/img/design/design4.jpg') }}'); 
                                    background-size: cover;
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    opacity: 0.5; 
                                    z-index: 0;
                                    display: block !important;
                                "></div>

                        <div class="container pt-4 pb-0" style="position: relative; z-index: 1;">
                            @if($products->count() > 0)
                            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000" data-bs-wrap="true">
                                <div class="carousel-inner">
                                    @foreach($products as $product)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <div class="d-flex justify-content-center">
                                            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white" style="width: 70%; min-height: 300px;">
                                                <div class="position-relative" style="height: 250px; width: 100%;">
                                                    <img src="{{ $product->image ? asset('storage/img/products/'.$product->image.'.jpg') : asset('img/no-image.png') }}"
                                                        class="w-100 h-100 p-3"
                                                        alt="{{ $product->name }}"
                                                        style="object-fit: contain;">

                                                    <div class="position-absolute top-0 start-0 m-2 w-75" style="z-index: 2;">
                                                        <span class="badge bg-primary fw-normal text-wrap text-start" style="font-size: 0.8rem; line-height: 1.2;">
                                                            {{ $product->name }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="card-body p-3 text-center">
                                                    <span class="badge bg-dark fs-6 px-4 py-2 shadow-sm" style="border-radius: 10px;">
                                                        {{ number_format($product->price, 0, '.', ' ') }} ₴
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Кнопки --}}
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev"
                                    style="width: 40px; height: 40px; position: absolute; top: 125px; left: 10px; opacity: 1; z-index: 10;">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"
                                        style="background-color: #0d6efd; border-radius: 50%; padding: 15px; background-size: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.2);"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next"
                                    style="width: 40px; height: 40px; position: absolute; top: 125px; right: 10px; opacity: 1; z-index: 10;">
                                    <span class="carousel-control-next-icon" aria-hidden="true"
                                        style="background-color: #0d6efd; border-radius: 50%; padding: 15px; background-size: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.2);"></span>
                                </button>
                            </div>
                            @endif
                        </div>

                        <div class="mt-auto p-4" style="background: linear-gradient(0deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0) 100%); position: relative; z-index: 1;">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h2 class="fw-bold mb-1" style="font-size: 1.75rem;">
                                        Next-Gen Gaming <span class="text-primary">Laptops</span>
                                    </h2>
                                    <p class="small opacity-75 mb-0 d-none d-md-block">
                                        Experience ultimate performance with the newest RTX 50-series graphics cards.
                                    </p>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <a href="{{ route('allProducts') }}" class="btn btn-primary px-4 fw-bold shadow-sm">
                                        Shop Now
                                    </a>
                                </div>
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