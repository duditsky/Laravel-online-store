@extends('layouts.default')

@section('content')
<div class="container py-5 text-center">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
    </div>
    
    <h3 class="mt-4 fw-bold text-dark">Redirecting to Payment Gateway...</h3>
    <p class="text-muted">Please wait, we are connecting you to LiqPay. Do not refresh the page.</p>

   <form id="liqpay-form-auto" method="POST" action="https://www.liqpay.ua/api/3/checkout" accept-charset="utf-8">
        <input type="hidden" name="data" value="{{ $data }}" />
        <input type="hidden" name="signature" value="{{ $signature }}" />
       
        <noscript>
            <button type="submit" class="btn btn-primary">Click here to pay</button>
        </noscript>
    </form>

   <script src="{{ asset('js/payment-redirect.js') }}"></script>
</div>
@endsection