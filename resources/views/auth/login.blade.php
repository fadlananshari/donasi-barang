<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- PWA -->
  <meta name="theme-color" content="#6777ef" />
  <link rel="apple-touch-icon" href="{{ asset('logo.png') }}" />
  <link rel="manifest" href="{{ asset('/manifest.json') }}" />

  <title>Login - BarangKita</title>
  <link rel="icon" type="image/png" href="{{ asset('icon512_rounded.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    .hero-img {
      max-height: 300px;
      object-fit: contain;
    }
    .form-control::placeholder {
      color: #4574a1;
    }
  </style>
</head>
<body>
  <div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100 rounded-4 overflow-hidden" style="max-width: 900px;">
      <!-- Left Column -->
      <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="fw-bold text-success">BarangKita</h1>
        <img src="{{ asset('img/login.png') }}" alt="Hero Image" class="img-fluid hero-img" />
        <p class="fw-medium">
          Donasi dan terima barang bisa di <span class="fw-semibold text-success">BarangKita</span>
        </p>
      </div>

      <!-- Right Column -->
      <div class="col-md-6 bg-white">
        <h1 class="text-center fw-bold fs-4 text-dark pb-3">
          Login
        </h1>

        <form method="POST">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label fw-medium text-dark">Email</label>
            <input
              type="email"
              class="form-control rounded-4 p-3 bg-light text-dark"
              name="email"
              id="email"
              placeholder="Masukkan email kamu"
              required
              autofocus
            />
            @error('email')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label fw-medium text-dark">Password</label>
            <input
              type="password"
              class="form-control rounded-4 p-3 bg-light text-dark"
              name="password"
              id="password"
              placeholder="Masukkan password kamu"
              required
            />
            @error('password')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="remember" id="remember">
            <label class="form-check-label" for="remember">Ingat saya</label>
          </div>

          <div class="d-grid mb-4">
            <button type="submit" class="btn btn-success rounded-pill">
              Masuk
            </button>
          </div>
        </form>

        <p class="text-center">
          <a href="{{ Route('home.signin') }}" class="small">
            Belum memiliki akun? daftar
          </a>
        </p>
      </div>
    </div>
  </div>

  <script src="{{ asset('/sw.js') }}"></script>
  <script>
    if ("serviceWorker" in navigator) {
      navigator.serviceWorker.register("/sw.js").then(
        (registration) => {
          console.log("Service worker registration succeeded:", registration);
        },
        (error) => {
          console.error(`Service worker registration failed: ${error}`);
        }
      );
    } else {
      console.error("Service workers are not supported.");
    }
  </script>
</body>
</html>
