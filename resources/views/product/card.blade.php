 <div class="card">
     <img src="{{url('img/'.$product->image.'.jpg')}}" class="card-img-top" alt="{{$product->name}}" style="height: 200px; object-fit: cover;">
     <div class="card-body">

         <h5 class="card-title">{{$product->name}}</h5>
         <p class="card-text">Price: ${{$product->price}}</p>
         <a href="{{route('productDetails',[$product->category->code,$product->code])}}" class="btn btn-primary">View Details</a>

         <form action="{{route('basket.add', $product)}}" method="POST">
             <button type="submit" class="btn btn-success">To Cart</button>
             @csrf
         </form>
        
     </div>
 </div>
