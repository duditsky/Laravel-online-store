<div class="card h-100 border-0 shadow-sm transition-hover" style="border-radius: 15px; overflow: hidden;">
    <div class="position-relative text-center p-3" style="background: #fdfdfd; height: 220px;">
        <img src="{{ $product->image ? url('img/'.$product->image.'.jpg') : url('img/no-image.jpg') }}" 
             class="card-img-top w-100 h-100" 
             alt="{{ $product->name }}" 
             style="object-fit: contain;">
    </div>

    <div class="card-body d-flex flex-column text-center">
        <h5 class="card-title mb-1" style="font-weight: 600; min-height: 48px;">
            {{ $product->name }}
        </h5>
        
        <div class="mb-3">
            <span class="h4" style="color: var(--main-color); font-weight: 700;">
                ${{ number_format($product->price, 2) }}
            </span>
        </div>

        <div class="d-grid gap-2 mt-auto">
                  <a href="{{ route('productDetails', ['category' => $product->category->code, 'product' => $product->code]) }}" 
               class="btn btn-outline-dark btn-sm rounded-pill" style="font-weight: 500;">
               VIEW DETAILS
            </a>

            <form action="{{ route('basket.add', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-dark w-100 rounded-pill shadow-sm py-2" style="font-weight: 600;">
                    ADD TO CART
                </button>
            </form>
        </div>
    </div>
</div>