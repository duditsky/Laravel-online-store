<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {{-- 1. ДОДАНО CSRF TOKEN ДЛЯ AJAX ЗАПИТІВ --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>JoyStore: @yield('title')</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

</head>

<body>
  <div class="top-header py-2 border-bottom" style="position: relative; z-index: 1100;">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="dropdown d-inline-block">
        <a class="nav-link dropdown-toggle p-0 text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-telephone text-warning"></i> +38 (099) 999-99-99
        </a>
        <ul class="dropdown-menu shadow border-0 mt-2" style="min-width: 180px; font-size: 0.85rem;">
          <li>
            <a class="dropdown-item py-1" href="tel:+380999999999">
              <i class="bi bi-telephone-outbound me-2 text-success"></i> +38 (099) 999-99-99
            </a>
          </li>
          <li>
            <hr class="dropdown-divider my-1">
          </li>
          <li>
            <button class="dropdown-item py-1 text-primary fw-bold" data-bs-toggle="modal" data-bs-target="#callbackModal">
              Call me back
            </button>
          </li>
        </ul>
      </div>
      <div class="d-flex align-items-center">
        @auth
        <div class="dropdown">
          <a class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0">
            <li>
              <a class="dropdown-item" href="{{ auth()->user()->can('admin-role') ? route('all.orders') : route('orders') }}">
                {{ auth()->user()->can('admin-role') ? 'All Orders' : 'My Orders' }}
              </a>
            </li>
            @can('admin-role')
            <li><a class="dropdown-item" href="{{ route('post.home') }}">Manage Posts</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            @endcan
            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
          </ul>
        </div>
        @else
        <a href="{{ route('login') }}" class="text-decoration-none text-dark me-3 small fw-bold">Login</a>
        <a href="{{ route('register.create') }}" class="text-decoration-none text-dark small fw-bold">Register</a>
        @endauth
      </div>
    </div>
  </div>

  <header class="py-3 bg-white sticky-top shadow-sm" style="z-index: 1050;">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-3 col-6 mb-3 mb-lg-0">
          <a class="navbar-brand fs-3 fw-bold text-uppercase" href="{{route('home')}}">
            <span class="text-warning">Joy</span>Store
          </a>
        </div>

        <div class="col-lg-6 col-12 order-3 order-lg-2">
          <form action="{{route('search')}}" method="GET" class="input-group">
            <input class="form-control search-input border-warning" type="search" name="search" placeholder="Search products..." aria-label="Search">
            <button class="btn btn-warning search-btn px-4" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </form>
        </div>

        <div class="col-lg-3 col-6 order-2 order-lg-3 text-end">
          <a href="{{ route('basket') }}" class="btn btn-outline-dark border-0 position-relative p-2">
            <i class="bi bi-cart3 fs-4"></i>

            @php
            $orderId = session('orderId');
            $totalItems = 0;
            if ($orderId) {
            $order = \App\Models\Order::find($orderId);
            if ($order) {
            $totalItems = $order->products->sum('pivot.count');
            }
            }
            @endphp

            {{-- 2. ДОДАНО ID basket-count ДЛЯ ОНОВЛЕННЯ ЦИФРИ --}}
            <span id="basket-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill {{ $totalItems > 0 ? 'bg-danger' : 'bg-secondary' }}">
              {{ $totalItems }}
            </span>

            <span class="d-none d-md-inline ms-1 fw-bold">Cart</span>
          </a>
        </div>
      </div>
    </div>
  </header>

  <nav class="navbar navbar-expand-lg bg-white border-bottom py-1">
    <div class="container">
      <button class="navbar-toggler w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#categoriesNav">
        <span class="navbar-toggler-icon"></span> PRODUCT CATALOG
      </button>
      <div class="collapse navbar-collapse" id="categoriesNav">
        <ul class="navbar-nav w-100 justify-content-between text-uppercase small">
          <li class="nav-item">
            <a class="nav-link text-dark fw-bold" href="{{route('allProducts')}}"><i class="bi bi-grid-3x3-gap me-1"></i> All Products</a>
          </li>
          <li class="nav-item"><a class="nav-link text-dark" href="{{route('categories')}}">Categories</a></li>
          <li class="nav-item"><a class="nav-link text-dark" href="#">Creativity</a></li>
          <li class="nav-item"><a class="nav-link text-dark" href="#">Leisure</a></li>
          <li class="nav-item"><a class="nav-link text-dark" href="#">Home Goods</a></li>
          <li class="nav-item"><a class="nav-link text-danger fw-bold" href="#">SALE %</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container mt-4 min-vh-100">
    @if ($errors->any())
    <div class="alert alert-danger shadow-sm border-0 border-start border-danger border-4">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    @if (session('info'))
    <div class="alert alert-info shadow-sm border-0 border-start border-info border-4">
      <i class="bi bi-info-circle-fill me-2"></i>{{ session('info') }}
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success shadow-sm border-0 border-start border-success border-4">
      <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
    @endif

    @yield('content')
  </main>

  <footer class="bg-dark text-white pt-5 pb-3 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4">
          <h5 class="text-warning fw-bold mb-3">JoyStore</h5>
          <p class="small text-secondary">
            JoyStore is a space for learning, creativity, and inspiration.
            We offer the best selection for students and creative professionals.
          </p>
          <div class="fs-4">
            <i class="bi bi-facebook me-2 cursor-pointer"></i>
            <i class="bi bi-instagram me-2 cursor-pointer"></i>
            <i class="bi bi-telegram cursor-pointer"></i>
          </div>
        </div>
        <div class="col-md-4 mb-4 text-md-center">
          <h5 class="fw-bold mb-3">Customer Info</h5>
          <ul class="list-unstyled small text-secondary">
            <li><a href="#" class="text-decoration-none text-secondary">About Us</a></li>
            <li><a href="#" class="text-decoration-none text-secondary">Delivery & Payment</a></li>
            <li><a href="#" class="text-decoration-none text-secondary">Contact Us</a></li>
          </ul>
        </div>
        <div class="col-md-4 mb-4 text-md-end">
          <h5 class="fw-bold mb-3">Contact Details</h5>
          <p class="small text-secondary mb-1"><i class="bi bi-geo-alt me-2"></i> Kyiv, Ukraine</p>
          <p class="small text-secondary mb-1"><i class="bi bi-envelope me-2"></i> support@joystore.ua</p>
        </div>
      </div>
      <hr class="border-secondary">
      <div class="text-center small text-secondary">
        &copy; {{ date('Y') }} JoyStore. Powered by Laravel.
      </div>
    </div>
  </footer>

  <x-chat-widget />

  <div class="modal fade" id="callbackModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
        <div class="modal-header bg-warning border-0 py-3">
          <h5 class="modal-title fw-bold text-dark">Call me back</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="{{ route('callback.store') }}" method="POST">
          @csrf
          <div class="modal-body px-4 pt-4">
            <div class="mb-3">
              <label class="form-label small text-muted mb-1">Your name</label>
              <input type="text" name="name" class="form-control border-2 shadow-none"
                style="border-color: #ffd700; border-radius: 8px;" placeholder="John Doe" required>
            </div>

            <div class="mb-3">
              <label class="form-label small text-muted mb-1">Your phone number</label>
              <input type="tel" id="phoneInput" name="phone"
                class="form-control border-2 shadow-none"
                autocomplete="off" required>
            </div>

            <p class="text-secondary mb-0" style="font-size: 0.8rem; line-height: 1.4;">
              We will call you back within 15 minutes.
            </p>
          </div>

          <div class="modal-footer border-0 px-4 pb-4 pt-0">
            <button type="submit" class="btn btn-warning w-100 fw-bold py-2" style="border-radius: 8px;">
              Send request
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/imask"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/chat.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/CallBackTel.js') }}"></script>

  {{-- 3. ДОДАНО СТЕК ДЛЯ ПІДКЛЮЧЕННЯ СКРИПТІВ З ІНШИХ СТОРІНОК --}}
  @stack('scripts')
</body>

</html>