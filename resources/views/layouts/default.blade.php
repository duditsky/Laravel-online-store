<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>JoyStore Tech: @yield('title')</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>
  <div class="top-header py-2 border-bottom bg-light" style="position: relative; z-index: 1100;">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="dropdown d-inline-block">
        <a class="nav-link dropdown-toggle p-0 text-dark small" href="#" role="button" data-bs-toggle="dropdown">
          <i class="bi bi-telephone text-primary"></i> +38 (099) 999-99-99
        </a>
        <ul class="dropdown-menu shadow border-0 mt-2">
          <li><a class="dropdown-item py-1" href="tel:+380999999999"><i class="bi bi-telephone-outbound me-2"></i> Call Support</a></li>
          <li><hr class="dropdown-divider my-1"></li>
          <li><button class="dropdown-item py-1 text-primary fw-bold" data-bs-toggle="modal" data-bs-target="#callbackModal">Request a Call</button></li>
        </ul>
      </div>
      <div class="d-flex align-items-center">
        @auth
        <div class="dropdown">
          <a class="nav-link dropdown-toggle fw-bold small" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-check"></i> {{ auth()->user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0">
            <li><a class="dropdown-item" href="{{ auth()->user()->can('admin-role') ? route('all.orders') : route('orders') }}">Dashboard</a></li>
            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
          </ul>
        </div>
        @else
        <a href="{{ route('login') }}" class="text-decoration-none text-dark me-3 small fw-bold">Login</a>
        <a href="{{ route('register.create') }}" class="btn btn-sm btn-outline-dark fw-bold" style="font-size: 0.75rem;">Join</a>
        @endauth
      </div>
    </div>
  </div>

  <header class="py-3 bg-white sticky-top shadow-sm" style="z-index: 1050;">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-3 col-6">
          <a class="navbar-brand fs-3 fw-bold text-uppercase" href="{{route('home')}}">
            <span class="text-primary border-bottom border-3 border-primary">Joy</span>Store
          </a>
        </div>

        <div class="col-lg-6 col-12 order-3 order-lg-2 mt-3 mt-lg-0">
          <form action="{{route('search')}}" method="GET" class="input-group">
            <input class="form-control border-primary" type="search" name="search" placeholder="Search laptops, GPUs, monitors..." aria-label="Search">
            <button class="btn btn-primary px-4" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </form>
        </div>

        <div class="col-lg-3 col-6 order-2 order-lg-3 text-end">
          <a href="{{ route('basket') }}" class="btn btn-dark position-relative p-2 rounded-3">
            <i class="bi bi-cpu fs-5 me-1"></i>
            @php
            $orderId = session('orderId');
            $totalItems = $orderId ? \App\Models\Order::find($orderId)?->products->sum('pivot.count') : 0;
            @endphp
            <span id="basket-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              {{ $totalItems ?? 0 }}
            </span>
            <span class="d-none d-md-inline ms-1 fw-bold">Cart</span>
          </a>
        </div>
      </div>
    </div>
  </header>

  <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-1">
    <div class="container">
      <button class="navbar-toggler w-100 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#categoriesNav">
        <i class="bi bi-list"></i> HARDWARE CATALOG
      </button>
      <div class="collapse navbar-collapse" id="categoriesNav">
        <ul class="navbar-nav w-100 justify-content-between text-uppercase small fw-semibold">
          <li class="nav-item"><a class="nav-link text-white" href="{{route('allProducts')}}"><i class="bi bi-pc-display me-1"></i> All Tech</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="{{route('categories')}}">PC Components</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">Laptops</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">Gaming Gear</a></li>
          <li class="nav-item"><a class="nav-link text-info fw-bold" href="#">NEW ARRIVALS</a></li>
          <li class="nav-item"><a class="nav-link text-warning fw-bold" href="#">HOT DEALS %</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container mt-4 min-vh-100">
    @yield('content')
  </main>

  <footer class="bg-dark text-white pt-5 pb-3 mt-5 border-top border-primary border-4">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4">
          <h5 class="text-primary fw-bold mb-3">JoyStore <span class="badge bg-primary text-dark" style="font-size: 0.6rem;">TECH</span></h5>
          <p class="small text-secondary">
            Your ultimate destination for high-performance hardware.
            From gaming rigs to professional workstations, we power your digital future.
          </p>
          <div class="fs-4">
            <i class="bi bi-github me-2 cursor-pointer"></i>
            <i class="bi bi-discord me-2 cursor-pointer"></i>
            <i class="bi bi-youtube cursor-pointer"></i>
          </div>
        </div>
        <div class="col-md-4 mb-4 text-md-center">
          <h5 class="fw-bold mb-3">Service & Support</h5>
          <ul class="list-unstyled small text-secondary">
            <li><a href="#" class="text-decoration-none text-secondary">Warranty Policy</a></li>
            <li><a href="#" class="text-decoration-none text-secondary">Custom PC Build</a></li>
            <li><a href="#" class="text-decoration-none text-secondary">Shipping Track</a></li>
          </ul>
        </div>
        <div class="col-md-4 mb-4 text-md-end">
          <h5 class="fw-bold mb-3">Tech HQ</h5>
          <p class="small text-secondary mb-1"><i class="bi bi-geo-alt me-2"></i> Silicon Valley Str, Kyiv</p>
          <p class="small text-secondary mb-1"><i class="bi bi-envelope me-2"></i> tech-support@joystore.ua</p>
        </div>
      </div>
      <hr class="border-secondary">
      <div class="text-center small text-secondary">
        &copy; {{ date('Y') }} JoyStore Tech. Professional Computer Hardware.
      </div>
    </div>
  </footer>

  <div class="modal fade" id="callbackModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
        <div class="modal-header bg-primary text-white border-0 py-3">
          <h5 class="modal-title fw-bold">Consult an Expert</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form action="{{ route('callback.store') }}" method="POST">
          @csrf
          <div class="modal-body px-4 pt-4">
            <div class="mb-3">
              <label class="form-label small text-muted">Name</label>
              <input type="text" name="name" class="form-control shadow-none border-primary" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
              <label class="form-label small text-muted">Phone Number</label>
              <input type="tel" id="phoneInput" name="phone" class="form-control shadow-none border-primary" required>
            </div>
            <p class="text-secondary small">Our technician will call you back to help with your choice.</p>
          </div>
          <div class="modal-footer border-0 px-4 pb-4 pt-0">
            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Call Me</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/imask"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/CallBackTel.js') }}"></script>
  <script src="{{ asset('js/cart.js') }}"></script>
  @stack('scripts')
  
</body>

</html>