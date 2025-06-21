<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title") &ndash; BarangKita</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-barangkita.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
      
      .text-hover-primary:hover {
        color: #0d6efd !important;
      }

      .text-hover-danger:hover {
        color: #dc3545 !important;
      }

      .text-hover-success:hover {
        color: #198754 !important;
      }

      .max-w-400px {
        max-width: 400px;
        margin: 0 auto;
      }

      .bg-f8f8f8 {
        background-color: #f8f8f8;
      }

      .min-h-screen {
        min-height: 100vh
      }

    </style>
    
  </head>
</head>
<body class="@yield("custom_body_class") bg-f8f8f8">

  <!-- FIXED-TOP -->
  <div class="fixed-top bg-white">
    <div class="container max-w-700px py-2 text-center border-bottom">
      <a class="navbar-brand fw-bold fs-3 text-primary" href="#">BarangKita</a>
    </div>
  </div>

  <!-- KONTEN UTAMA -->
  <main class="max-w-400px pt-5 pb-5 bg-white min-h-screen">
    @yield('content')

  </main>

  <!-- NAVBAR FIXED-BOTTOM -->
  <nav class="navbar fixed-bottom p-0">
    <div class="container max-w-400px py-2 border-top justify-content-around bg-white">
      <a class="nav-link text-center @yield("active-menu-home")" href='#'>
        <i class="bi bi-house-door-fill fs-5"></i><br><p class="m-0">Beranda</p>
      </a>
      <a class="nav-link text-center @yield("active-menu-donate")" href="#">
        <i class="bi bi-archive-fill fs-5"></i><br><p class="m-0">Donasi</p>
      </a>
      <a class="nav-link text-center @yield("active-menu-delivery")" href='#'>
        <i class="bi bi-box-seam-fill fs-5"></i><br><p class="m-0">Pengiriman</p>
      </a>
      <a class="nav-link text-center @yield("active-menu-profile")" href='#'>
        <i class="bi bi-person-circle fs-5"></i><br><p class="m-0">Profil</p>
      </a>
    </div>
  </nav>

  @yield('custom_script')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js" integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous"></script>
</body>
</html>