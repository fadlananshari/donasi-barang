<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="BarangKita adalah platform donasi barang terpercaya untuk membantu sesama. Galang dan sumbangkan barang dengan mudah dan transparan.">

  {{-- PWA --}}
  <meta name="theme-color" content="#6777ef"/>
  <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
  <link rel="manifest" href="{{ asset('/manifest.json') }}">

  {{-- Favicon --}}
  <link rel="icon" type="image/png" href="{{ asset('icon512_rounded.png') }}">
  <link rel="preload" as="image" href="{{ asset('icon512_rounded.png') }}" />

  {{-- Title --}}
  <title>@yield("title") &ndash; BarangKita</title>

  {{-- Preload Bootstrap --}}
  <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"></noscript>

  {{-- Bootstrap Icons --}}
  <link rel="stylesheet" href="{{ asset('/css/bootstrap-icons-1.13.1/bootstrap-icons.css') }}">

  {{-- Custom CSS --}}
  @yield('custom_link')

  <style>
    #navbar {
      transition: box-shadow 0.3s ease-in-out;
    }

    .navbar-shadow {
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    @yield("custom_css");
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

  {{-- Navbar --}}
  <nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-success" aria-label="Beranda" href="{{ route('penerima.index') }}">
        <img src="{{ asset('icon512_rounded.png') }}" alt="Logo BarangKita" width="50" height="50" loading="lazy" decoding="async">
        BarangKita
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTop" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarTop">
        <ul class="navbar-nav mb-2 mb-lg-0 text-center">
          <li class="nav-item my-auto">
            <a class="nav-link text-secondary @yield('active-menu-home')" href="{{ route('penerima.index') }}" aria-label="Beranda">Beranda</a>
          </li>
          <li class="nav-item my-auto">
            <a class="nav-link text-secondary @yield('active-menu-proposal')" href="{{ route('penerima.proposal') }}" aria-label="Proposal">Proposal</a>
          </li>
          <li class="nav-item my-auto">
            @auth
              <a class="nav-link text-secondary @yield('active-menu-profile')" href="{{ route('penerima.profile') }}" aria-label="Profil">
                <i class="bi bi-person-circle fs-3 d-block"></i>
              </a>
            @endauth
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- Main Content --}}
  <main class="flex-grow-1 pt-5 mt-4">
    @yield('content')
  </main>

  {{-- Footer --}}
  <footer class="border-top mt-5">
    <div class="container py-4">
      <div class="row">
        <div class="col-md-6 mb-3">
          <h5 class="text-success fw-bold">BarangKita</h5>
          <p class="text-muted small">
            Platform donasi barang untuk membantu sesama. Sumbangkan barang layak pakai dan wujudkan perubahan nyata.
          </p>
        </div>
        <div class="col-md-3 mb-3">
          <h6 class="fw-semibold">Navigasi</h6>
          <ul class="list-unstyled small">
            <li><a href="{{ route('penerima.index') }}" class="text-muted text-decoration-none" aria-label="Beranda">Beranda</a></li>
            <li><a href="{{ route('penerima.proposal') }}" class="text-muted text-decoration-none" aria-label="Proposal">Proposal</a></li>
            <li><a href="{{ route('penerima.profile') }}" class="text-muted text-decoration-none" aria-label="Profil">Profil</a></li>
          </ul>
        </div>
        <div class="col-md-3 mb-3">
          <h6 class="fw-semibold">Hubungi Kami</h6>
          <ul class="list-unstyled small text-muted">
            <li><a href="mailto:barangkita25@gmail.com" class="text-muted text-decoration-none" aria-label="Mail to barangkita25@gmail.com">barangkita25@gmail.com</a></li>
          </ul>
        </div>
      </div>
      <hr>
      <div class="text-center small text-muted">
        &copy; {{ date('Y') }} BarangKita. Semua hak dilindungi.
      </div>
    </div>
  </footer>

  {{-- Bootstrap Bundle JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" defer></script>

  {{-- Script tambahan --}}
  @yield('custom_script')

  {{-- Service Worker --}}
  <script>
    if ("serviceWorker" in navigator) {
      navigator.serviceWorker.register("/sw.js").then(
        reg => console.log("Service worker berhasil:", reg),
        err => console.error("Service worker gagal:", err)
      );
    }
  </script>

  {{-- Navbar Scroll Shadow --}}
  <script>
    window.addEventListener('scroll', () => {
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
