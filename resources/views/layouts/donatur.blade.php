<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- PWA -->
  <meta name="theme-color" content="#6777ef"/>
  <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
  <link rel="manifest" href="{{ asset('/manifest.json') }}">

  <title>@yield("title") &ndash; BarangKita</title>
  <link rel="icon" type="image/png" href="{{ asset('icon512_rounded.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  @yield('custom_link')

  <style>
    #navbar {
      transition: box-shadow 0.3s ease-in-out;
    }
  
    .navbar-shadow {
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Shadow custom */
    }
    @yield("custom_css");
  </style>
  
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- Navbar -->
  <nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-success" href="{{ route('donatur.index') }}">
        <img src="{{ asset('icon512_rounded.png') }}" alt="Logo" width="50">
        BarangKita
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTop">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarTop">
        <ul class="navbar-nav mb-2 mb-lg-0 text-center">
          <li class="nav-item my-auto">
            <a class="nav-link text-secondary @yield('active-menu-home')" href="{{ route('donatur.index') }}">Beranda</a>
          </li>
          <li class="nav-item my-auto">
            <a class="nav-link text-secondary @yield('active-menu-donate')" href="{{ route('donatur.proposal') }}">Proposal</a>
          </li>
          <li class="nav-item my-auto">
            <a class="nav-link text-secondary @yield('active-menu-delivery')" href="{{ route('donatur.pengiriman') }}">Pengiriman</a>
          </li>
          <li class="nav-item my-auto">
            @auth
              <a class="nav-link text-secondary @yield('active-menu-profile')" href="{{ route('donatur.profile') }}">
                <i class="bi bi-person-circle fs-3 d-block"></i>
              </a>
            @endauth
            @guest
              <a class="btn btn-success px-3 py-1" href="{{ route('home.signin') }}">Daftar</a>
            @endguest
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Konten Utama -->
  <main class="flex-grow-1 pt-5 mt-4">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="border-top mt-5">
    <div class="container py-4">
      <div class="row">
        <div class="col-md-6 mb-3">
          <h5 class="text-success fw-bold">Barangkita</h5>
          <p class="text-muted small">
            Platform donasi barang untuk membantu sesama. Sumbangkan barang layak pakai dan wujudkan perubahan nyata.
          </p>
        </div>
        <div class="col-md-3 mb-3">
          <h6 class="fw-semibold">Navigasi</h6>
          <ul class="list-unstyled small">
            <li><a href="{{ route('donatur.index') }}" class="text-muted text-decoration-none">Beranda</a></li>
            <li><a href="{{ route('donatur.proposal') }}" class="text-muted text-decoration-none">Proposal</a></li>
            <li><a href="{{ route('donatur.pengiriman') }}" class="text-muted text-decoration-none">Pengiriman</a></li>
            <li><a href="{{ route('donatur.profile') }}" class="text-muted text-decoration-none">Profil</a></li>
          </ul>
        </div>
        <div class="col-md-3 mb-3">
          <h6 class="fw-semibold">Hubungi Kami</h6>
          <ul class="list-unstyled small text-muted">
            <li>barangkita25@gmail.com</li>
          </ul>
        </div>
      </div>
      <hr>
      <div class="text-center small text-muted">
        &copy; {{ date('Y') }} Barangkita. Semua hak dilindungi.
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  @yield('custom_script')

  <script src="{{ asset('/sw.js') }}"></script>
  <script>
    if ("serviceWorker" in navigator) {
      navigator.serviceWorker.register("/sw.js").then(
        registration => console.log("Service worker registration succeeded:", registration),
        error => console.error("Service worker registration failed:", error)
      );
    }
  </script>
  <script>
    window.addEventListener('scroll', function () {
      const navbar = document.getElementById('navbar');
      if (window.scrollY === 0) {
        navbar.classList.remove('shadow');
      } else {
        navbar.classList.add('shadow');
      }
    });
  </script>
  
</body>
</html>
