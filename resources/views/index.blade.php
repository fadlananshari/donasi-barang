<!DOCTYPE html>
<html lang="en">
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
  <title>BarangKita</title>

  {{-- Preload Bootstrap --}}
  <link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"></noscript>

  {{-- Bootstrap Icons --}}
  <link rel="stylesheet" href="{{ asset('/css/bootstrap-icons-1.13.1/bootstrap-icons.css') }}">


  <style>
    #navbar {
      transition: box-shadow 0.3s ease-in-out;
    }
    .navbar-shadow {
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Shadow custom */
    }
    section h1 {
        font-size: 2.5rem; /* Explicit heading size */
    }
    .hover-shadow {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.18);
        transition: box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1), transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hover-shadow:hover {
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
        transform: translateY(-4px);
    }
    .overflow-auto::-webkit-scrollbar {
        display: none;
    }
  </style>
  
</head>
<body class="d-flex flex-column">
  <!-- Navbar -->
  <nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-success" href="{{ route('landingPage') }}">
        <img src="{{ asset('icon512_rounded.png') }}" alt="Logo BarangKita" width="50">
        <span class="d-none d-md-block">
          BarangKita
        </span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTop">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarTop">
        <ul class="navbar-nav mb-2 mb-lg-0 text-center">
          <li class="nav-item my-auto">
            <a class="nav-link text-secondary active text-success" href="{{ route('landingPage') }}" aria-label="Halaman Beranda">Beranda</a>
          </li>
          <li class="nav-item my-auto">
            <a class="nav-link text-secondary" href="{{ route('login') }}" aria-label="Halaman Proposal">Proposal</a>
          </li>
          <li class="nav-item my-auto">
          </li>
          <li class="nav-item my-auto">
            <a href="{{route('login')}}" class="btn btn-success">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Konten Utama -->
  <main class="flex-grow-1 pt-5 mt-4">
    <section class="py-5">
        <div class="container">
      
          {{-- HERO --}}
          <div class="row align-items-center mb-5 mx-3">
            <div class="col-md-5 mb-4 mb-md-0" data-aos="fade-right">
              <img src="{{ asset('img/login.png') }}" alt="Ilustrasi Donasi Barang" class="img-fluid" />
            </div>
            <div class="col-md-6" data-aos="fade-left">
              <h1 class="display-5 fw-bold mb-3">Donasi dan terima barang bisa di <span class="text-success">BarangKita</span></h1>
              <p class="text-muted mb-4">BarangKita menghubungkan kebaikanmu dengan mereka yang membutuhkan. Mulai berdonasi sekarang dan bantu mereka yang kurang beruntung.</p>
              <a href="{{ route('donatur.proposal') }}" class="btn btn-success btn-lg px-4 py-2">Mulai Sekarang</a>
            </div>
          </div>
      
          {{-- PROPOSAL TERBARU --}}
          <div class="mt-5">
            <div class="d-flex justify-content-between mb-3">
              <h2 class="text-success fw-bold">Proposal Terbaru</h2>
              <a href="{{ route('donatur.proposal') }}" class="text-decoration-none my-auto" aria-label="Lihat semua proposal donasi">Lihat Semua</a>
            </div>
      
            @if ($proposals->isNotEmpty())
              <div class="overflow-auto pb-2" style="white-space: nowrap;">
                <div class="d-flex flex-nowrap" style="gap: 16px;">
                  @foreach ($proposals->take(5) as $proposal)
                    <a href="{{ route('donatur.detailProposal', $proposal->id) }}" 
                      class="card flex-row border text-decoration-none"
                      style="height: 170px; width: 640px; flex: 0 0 auto;"
                      aria-label="Detail proposal {{ $proposal->title }} oleh {{ $proposal->user->name }}">
      
                      <div class="col-5 h-100">
                        <img
                          src="{{ asset('storage/' . $proposal->image_campaign) }}"
                          alt="Gambar proposal {{ $proposal->title }}"
                          class="img-fluid object-fit-cover rounded-start h-100"
                          style="width: 100%; object-fit: cover;">
                      </div>
      
                      <div class="col-7 my-auto p-2 rounded-end">
                        <h3 class="card-title fw-bold m-0 fs-5">{{ $proposal->title }}</h3>
                        <p class="card-text text-muted small mb-2 mb-md-3" style="font-size: 12px">
                          {{ $proposal->user->name }}
                        </p>
      
                        <div class="progress mb-2 mb-md-3" style="height: 3px;">
                          <div class="progress-bar bg-success"
                              role="progressbar"
                              style="width: {{$proposal->donation_percent}}%;"
                              aria-valuenow="{{$proposal->donation_percent}}"
                              aria-valuemin="0"
                              aria-valuemax="100"
                              aria-label="Donasi terkumpul {{$proposal->donation_percent}} persen">
                          </div>
                        </div>
      
                        <div class="d-flex justify-content-between">
                          <div>
                            <p class="small m-0 text-muted" style="font-size: 12px">Dibutuhkan</p>
                            <p class="small fw-semibold" style="font-size: smaller">
                              {{ $proposal->total_quantity }} Barang
                            </p>
                          </div>
                          <div>
                            <p class="small m-0 text-muted" style="font-size: 12px">Terkumpul</p>
                            <p class="small fw-semibold" style="font-size: smaller">
                              {{ $proposal->donated_quantity }} Barang
                            </p>
                          </div>
                        </div>
                      </div>
                    </a>
                  @endforeach
                </div>
              </div>
            @else
              <p class="text-center small text-secondary mt-5">Belum ada proposal</p>
            @endif
          </div>
      
          {{-- FITUR UTAMA --}}
          <div class="text-center my-5 py-5 bg-success bg-opacity-10 px-5">
            <h2 class="fw-bold mb-4">Apa Saja Fitur Utama <span class="text-success">BarangKita</span>?</h2>
            <div class="row g-4 mt-4">
              @php
                $features = [
                  ['icon' => 'box-seam', 'title' => 'Donasi Barang', 'desc' => 'Sumbangkan barang seperti pakaian, buku, alat sekolah, dan lainnya dengan mudah.'],
                  ['icon' => 'search', 'title' => 'Lihat Proposal', 'desc' => 'Temukan lembaga atau individu yang mengajukan kebutuhan barang.'],
                  ['icon' => 'eye', 'title' => 'Pantau Donasi', 'desc' => 'Lihat progres pengumpulan dan distribusi barang secara real-time.'],
                ];
              @endphp
              @foreach($features as $feature)
                <div class="col-md-4">
                  <div class="bg-white border-0 rounded-4 shadow-sm h-100 p-4 text-center" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                    <i class="bi bi-{{ $feature['icon'] }} text-success fs-1 mb-3" aria-hidden="true"></i>
                    <h3 class="fs-5 fw-semibold mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-muted small">{{ $feature['desc'] }}</p>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
      
          {{-- CARA DONASI --}}
          <section class="pt-5 pb-4 position-relative">
            <div class="container mb-5">
              <h2 class="text-center fw-bold mb-5">Cara Donasi Barang</h2>
      
              @php
                $steps = [
                  ['icon' => 'file-earmark-text', 'title' => 'Pilih Proposal', 'desc' => 'Telusuri daftar proposal dan pilih kebutuhan yang ingin kamu bantu.'],
                  ['icon' => 'box-seam', 'title' => 'Kirim Barang', 'desc' => 'Kemas barang sesuai kebutuhan dan kirim ke alamat yang tertera di proposal.'],
                  ['icon' => 'clipboard-check', 'title' => 'Isi Formulir', 'desc' => 'Laporkan pengiriman melalui formulir donasi untuk verifikasi.'],
                  ['icon' => 'eye', 'title' => 'Pantau Donasi', 'desc' => 'Lacak status dan dampak dari donasimu secara langsung.'],
                ];
              @endphp
      
              <div class="row g-4 justify-content-center">
                @foreach($steps as $index => $step)
                  <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 rounded-4 text-center p-4 bg-white hover-shadow" data-aos="fade-up">
                      <div class="text-success fs-1 mb-3">
                        <i class="bi bi-{{ $step['icon'] }}" aria-hidden="true"></i>
                      </div>
                      <h4 class="fs-6 fw-bold mb-2">{{ $step['title'] }}</h4>
                      <p class="text-muted small">{{ $step['desc'] }}</p>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </section>
      
          {{-- CTA --}}
          <div class="text-center mt-5 py-5 bg-success bg-opacity-10 px-2" data-aos="fade-up">
            <h2 class="fw-bold text-success">Ayo Berdonasi, Sekarang!</h2>
            <p class="text-muted mb-4">Barang tak terpakai di rumahmu bisa jadi harapan baru bagi mereka yang membutuhkan.  
            Mulai donasimu hari ini dan wujudkan kebaikan nyata!</p>
            <a href="{{ route('donatur.proposal') }}" class="btn btn-success px-4 py-2">Mulai Sekarang</a>
          </div>
      
        </div>
      </section>
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
            <li><a href="{{ route('landingPage') }}" class="text-muted text-decoration-none d-block py-2" aria-label="Link ke Beranda">Beranda</a></li>
            <li><a href="{{ route('login') }}" class="text-muted text-decoration-none d-block py-2" aria-label="Link ke Proposal">Proposal</a></li>
            <li><a href="{{ route('login') }}" class="text-muted text-decoration-none d-block py-2" aria-label="Link Login">Login</a></li>            
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
