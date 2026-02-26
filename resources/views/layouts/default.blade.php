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
          <i class="bi bi-telephone text-primary"></i> +38 (099) 199-47-74
        </a>
        <ul class="dropdown-menu shadow border-0 mt-2">
          <li><a class="dropdown-item py-1" href="tel:+380991994774"><i class="bi bi-telephone-outbound me-2"></i> Call Support</a></li>
          <li>
            <hr class="dropdown-divider my-1">
          </li>
          <li><button class="dropdown-item py-1 text-primary fw-bold" data-bs-toggle="modal" data-bs-target="#callbackModal">Request a Call</button></li>
        </ul>
      </div>
      <div class="d-flex align-items-center">
        @auth
        <div class="dropdown">
          <a class="nav-link dropdown-toggle fw-bold small" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-check"></i> {{ auth()->user()->name }}
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2 mt-2" style="border-radius: 12px; min-width: 240px;">

            @if(auth()->user()->can('admin-role'))
            <li class="dropdown-header small text-uppercase fw-bold text-primary d-flex align-items-center" style="font-size: 0.7rem; letter-spacing: 1px; padding-bottom: 5px;">
              <i class="bi bi-shield-lock-fill me-2"></i> Admin Panel
            </li>

            <li>
              <a class="dropdown-item py-2 fw-semibold" href="{{ route('all.orders') }}">
                <i class="bi bi-ui-checks me-2 text-primary"></i> Order Processing
              </a>
            </li>

            <li>
              <a class="dropdown-item py-2 fw-semibold" href="{{ route('post.index') }}">
                <i class="bi bi-chat-quote me-2 text-primary"></i> Review Moderation
              </a>
            </li>
            @else
            <li class="dropdown-header small text-uppercase fw-bold opacity-50" style="font-size: 0.6rem;">My Account</li>
            <li>
              <a class="dropdown-item py-2" href="{{ route('orders') }}">
                <i class="bi bi-bag me-2 opacity-75"></i> My Orders history
              </a>
            </li>
            @endif

            <li>
              <hr class="dropdown-divider opacity-50">
            </li>

            <li>
              <a class="dropdown-item text-danger py-2" href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
              </a>
            </li>
          </ul>
        </div>
        @else
        <div class="d-flex align-items-center">
          <a href="{{ route('login') }}" class="text-decoration-none text-dark me-3 small fw-bold">Login</a>
          <a href="{{ route('register.create') }}" class="btn btn-sm btn-outline-dark fw-bold px-3 rounded-pill shadow-sm" style="font-size: 0.75rem;">Join</a>
        </div>
        @endauth
      </div>
    </div>
  </div>

  <header class="py-3 bg-white sticky-top shadow-sm" style="z-index: 1050;">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-3 col-6">
          <a class="navbar-brand fs-4 fw-bold text-uppercase d-flex align-items-center" href="{{route('home')}}" style="text-decoration: none; gap: 6px;">
            <div class="d-flex align-items-center">
              <span class="text-primary">Joy</span><span class="text-dark">Store</span>
            </div>
            <span class="badge bg-primary text-white fst-italic d-flex align-items-center justify-content-center"
              style="border-radius: 6px; height: 22px; padding: 0 8px; font-size: 0.55em; margin-top: 1px; letter-spacing: 0.5px;">
              TECH
            </span>
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
            <i class="bi bi-cart3 fs-5 me-1"></i>
            @php
            $orderId = session('orderId');
            $totalItems = $orderId ? \App\Models\Order::find($orderId)?->products()->sum('order_product.count') : 0;
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

  <nav class="navbar navbar-expand-lg category-navbar navbar-dark py-0">
    <div class="container">
      <button class="navbar-toggler w-100 border-0 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#categoriesNav">
        <i class="bi bi-list"></i> HARDWARE CATALOG
      </button>
      <div class="collapse navbar-collapse" id="categoriesNav">
        <ul class="navbar-nav w-100 justify-content-between text-uppercase small fw-bold">
          <li class="nav-item">
            <a class="nav-link text-white" href="{{route('allProducts')}}">
              <i class="bi bi-grid-fill"></i> All Tech
            </a>
          </li>

          <li class="nav-item mega-menu-item">
            <a class="nav-link text-white d-flex align-items-center" href="{{route('categories')}}">
              <i class="bi bi-cpu"></i> PC Components
            </a>

            <div class="mega-menu-content shadow-lg">
              <div class="container py-4">
                <div class="row g-4 justify-content-start">
                  @foreach($categories as $category)
                  <div class="col-md-2 text-center">
                    <a href="{{ route('category', $category->code) }}" class="category-link text-decoration-none text-dark">
                      <div class="img-wrapper mb-2 p-2 border rounded-3 bg-light">
                        @if($category->image)
                        <img src="{{ asset('storage/img/categories/' . $category->image . '.jpg') }}" alt="{{ $category->name }}" class="img-fluid">
                        @else
                        <img src="{{ asset('img/no-image.png') }}" alt="No image" class="img-fluid">
                        @endif
                      </div>
                      <p class="fw-bold small text-uppercase mb-0">{{ $category->name }}</p>
                    </a>
                  </div>
                  @endforeach

                  <div class="col-md-2 text-center">
                    <a href="{{ route('categories') }}" class="all-cats-btn d-flex flex-column align-items-center justify-content-center h-100 border rounded-3 p-3 text-decoration-none">
                      <span class="fw-bold text-muted small text-uppercase text-center">See all<br>Components ></span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link text-white" href="#">
              <i class="bi bi-laptop"></i> Laptops
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-white" href="#">
              <i class="bi bi-controller"></i> Gaming Gear
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-info fw-bold" href="#">
              <i class="bi bi-stars"></i> NEW ARRIVALS
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-danger fw-bold" href="#">
              <i class="bi bi-fire"></i> HOT DEALS %
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  @if(Route::is('home'))
  <div class="modern-hero">
    <div class="hero-image-container">
      <img src="{{ asset('storage/img/design/design.3.jpg') }}" alt="Tech Banner" class="hero-parallax-img">
    </div>
    <div class="hero-overlay">
      <div class="container h-100 d-flex align-items-center">
      </div>
    </div>
  </div>
  @else
  <div class="modern-hero" style="height: 150px;">
    <div class="hero-image-container">
      <img src="{{ asset('storage/img/design/design.3.jpg') }}" alt="Tech Banner" class="hero-parallax-img">
    </div>
    <div class="hero-overlay">
      <div class="container h-100 d-flex align-items-center">
      </div>
    </div>
  </div>
  @endif

  <div class="content-wrapper">
    @yield('content')
  </div>
  @include('components.chat-widget')
  <footer class="bg-dark text-white pt-5 pb-3 border-top border-primary border-4">
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
  <script src="{{ asset('js/chat.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>

  @stack('scripts')

</body>

</html>