<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Store: @yield('title')</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{route('home')}}">Online Store</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{route('allProducts')}}">All Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('categories')}}">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('basket')}}">Basket</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          @auth
            @cannot('admin-role')
            <li class="nav-item">
              <a class="nav-link" href="{{route('orders')}}"><b>Hello: {{auth()->user()->name}}</b></a>
            </li>
            @endcan
            
            @can('admin-role')
            <li class="nav-item">
              <a class="nav-link" href="{{route('all.orders')}}"><b>Hello: {{auth()->user()->name}}</b></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('post.home')}}"><b>All Posts</b></a>
            </li>
            @endcan
            
            <li class="nav-item">
              <a class="nav-link" href="{{route('logout')}}">Logout</a>
            </li>
            
            @can('create', App\Models\Post::class)
            <li class="nav-item">
              <a class="nav-link" href="{{route('posts.create')}}">New post</a>
            </li>
            @endcan
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{route('register.create')}}">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('login')}}">Login</a>
            </li>
          @endauth
        </ul>
        <form class="d-flex" action="{{route('search')}}" method="GET">
          <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <div class="container mt-3">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

  
    @yield('content')
  </div>

  <x-chat-widget />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/chat.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>