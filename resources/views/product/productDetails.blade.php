@extends('layouts.default')

@section('title', $product->name . ' - Product Details')

@section('content')
<div class="container py-5">
    <div class="row g-5">
        <div class="col-md-6 text-center">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 20px; background: #fff;">
                <img src="{{ url('img/'.$product->image.'.jpg') }}" 
                     class="img-fluid rounded" 
                     alt="{{ $product->name }}" 
                     style="max-height: 500px; object-fit: contain;">
            </div>
        </div>

        <div class="col-md-6">
            <div class="product-selection-wrapper ps-md-4">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Home</a></li>
                        <li class="breadcrumb-item">
                            <a href="/categories/{{ $product->category->code }}" class="text-decoration-none text-muted">
                                {{ $product->category->name }}
                            </a>
                        </li>
                    </ol>
                </nav>

                <h1 class="display-6 fw-bold mb-3 text-dark">{{ $product->name }}</h1>
                
                <div class="price-section mb-4">
                    <span class="h2 fw-bold" style="color: var(--main-color);">${{ number_format($product->price, 2) }}</span>
                </div>

                <form action="{{ route('basket.add', $product) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="quantity" class="form-label small fw-bold text-muted">QUANTITY:</label>
                        <input type="number" name="quantity" id="quantity" class="form-control shadow-sm" 
                               value="1" min="1" max="99" style="width: 90px; border-radius: 10px;">
                    </div>
                    
                    <button type="submit" class="btn btn-dark btn-lg w-100 shadow py-3" style="border-radius: 12px; font-weight: 700;">
                        ADD TO SHOPPING CART
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="description-container p-4 bg-white shadow-sm border-0" style="border-radius: 15px;">
                <h5 class="fw-bold mb-3">Product Description</h5>
                <p class="text-muted lh-base" style="font-size: 1rem;">
                    {{ $product->description }}
                </p>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-8">
            <h6 class="text-uppercase fw-bold text-muted mb-4" style="letter-spacing: 1px;">
                Reviews ({{ $product->posts->count() }})
            </h6>

            @forelse($product->posts as $post)
            <div class="card border-0 bg-light mb-2" style="border-radius: 10px;">
                <div class="card-body py-2 px-3">
                    <div class="d-flex align-items-baseline">
                        <strong class="small me-2">{{ $post->user->name }}:</strong>
                        <span class="text-secondary small">{{ $post->text }}</span>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted small">No reviews yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection@extends('layouts.default')

@section('title', $product->name . ' - Product Details')

@section('content')
<div class="container py-5">
    <div class="row g-5">
        <div class="col-md-6 text-center">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 20px; background: #fff;">
                <img src="{{ url('img/'.$product->image.'.jpg') }}" 
                     class="img-fluid rounded" 
                     alt="{{ $product->name }}" 
                     style="max-height: 500px; object-fit: contain;">
            </div>
        </div>

        <div class="col-md-6">
            <div class="product-selection-wrapper ps-md-4">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Home</a></li>
                        <li class="breadcrumb-item">
                            <a href="/categories/{{ $product->category->code }}" class="text-decoration-none text-muted">
                                {{ $product->category->name }}
                            </a>
                        </li>
                    </ol>
                </nav>

                <h1 class="display-6 fw-bold mb-3 text-dark">{{ $product->name }}</h1>
                
                <div class="price-section mb-4">
                    <span class="h2 fw-bold" style="color: var(--main-color);">${{ number_format($product->price, 2) }}</span>
                </div>

                <form action="{{ route('basket.add', $product) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="quantity" class="form-label small fw-bold text-muted">QUANTITY:</label>
                        <input type="number" name="quantity" id="quantity" class="form-control shadow-sm" 
                               value="1" min="1" max="99" style="width: 90px; border-radius: 10px;">
                    </div>
                    
                    <button type="submit" class="btn btn-dark btn-lg w-100 shadow py-3" style="border-radius: 12px; font-weight: 700;">
                        ADD TO SHOPPING CART
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="description-container p-4 bg-white shadow-sm border-0" style="border-radius: 15px;">
                <h5 class="fw-bold mb-3">Product Description</h5>
                <p class="text-muted lh-base" style="font-size: 1rem;">
                    {{ $product->description }}
                </p>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-8">
            <h6 class="text-uppercase fw-bold text-muted mb-4" style="letter-spacing: 1px;">
                Reviews ({{ $product->posts->count() }})
            </h6>

            @forelse($product->posts as $post)
            <div class="card border-0 bg-light mb-2" style="border-radius: 10px;">
                <div class="card-body py-2 px-3">
                    <div class="d-flex align-items-baseline">
                        <strong class="small me-2">{{ $post->user->name }}:</strong>
                        <span class="text-secondary small">{{ $post->text }}</span>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted small">No reviews yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection