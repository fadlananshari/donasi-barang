<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- <!-- PWA  -->
  <meta name="theme-color" content="#6777ef"/>
  <link rel="apple-touch-icon" href="{{ asset('img/logo-barangkita.png') }}">
  <link rel="manifest" href="{{ asset('/manifest.json') }}"> --}}
  
  <title>Login - BarangKita</title>
  <link rel="icon" type="image/png" href="{{ asset('img/logo-barangkita.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: "Spline Sans", "Noto Sans", sans-serif;
      background-color: #f8fafc;
    }
    .bg-hero {
      background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB8CNFAHwn-7oFV7EEfLqqYrqfk5Zx7UPqi_q9XPKCDV2wtU2wT7lGvm2otTRE_a5LHpWHsqpOy-XBjcFK_bcxkcKvHSXHldZyFy1Q3H4_3_qGfSfK-tBBfsg4K-CcXRoemerwQxJP6Clv7DP_HuOIGMU5o7SLxfPx24rMKNXYVLwSQmOCaB6dnxp6prSyEamlGY9zisqFcwEA7dGQomXmuq2ZRuLYMjyiY2zLm8HyQ3Q-Y2yqQCec_PRnXExum49C_zDUjnSoX8GE");
      background-size: cover;
      background-position: center;
      border-radius: 1rem;
      min-height: 218px;
    }
    .form-control::placeholder {
      color: #4574a1;
    }
  </style>
</head>
<body class="bg-light">
  <div class="">
    <div class="card shadow px-5 mx-auto" style="max-width: 500px; min-height: 100vh;">

      <div class="">
        <img 
          src="{{asset('img/login.png')}}"
          alt="Hero Image"
          class="img-fluid w-100 mb-4 rounded"
          style="max-height: 300px; object-fit: contain;"
        />

        {{-- <img 
          src="https://lh3.googleusercontent.com/aida-public/AB6AXuB8CNFAHwn-7oFV7EEfLqqYrqfk5Zx7UPqi_q9XPKCDV2wtU2wT7lGvm2otTRE_a5LHpWHsqpOy-XBjcFK_bcxkcKvHSXHldZyFy1Q3H4_3_qGfSfK-tBBfsg4K-CcXRoemerwQxJP6Clv7DP_HuOIGMU5o7SLxfPx24rMKNXYVLwSQmOCaB6dnxp6prSyEamlGY9zisqFcwEA7dGQomXmuq2ZRuLYMjyiY2zLm8HyQ3Q-Y2yqQCec_PRnXExum49C_zDUjnSoX8GE"
          alt="Hero Image"
          class="w-100 rounded mb-4"
          style="max-height: 180px; object-fit: cover;"
        /> --}}

        <p class="text-center">Donasi dan terima barang bisa di <span class="fw-semibold text-success">BarangKita</span></p>
        
        <h1 class="text-center fw-bold fs-4 text-dark pb-3 pt-2">
          Login
        </h1>

        <form method="POST">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label fw-medium text-dark">Email</label>
            <input
              type="email"
              class="form-control rounded-4 p-3 bg-light border-0 text-dark"
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
              class="form-control rounded-4 p-3 bg-light border-0 text-dark"
              name="password"
              id="password"
              placeholder="Masukkan password kamu"
              required
            />
            @error('password')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <!-- Remember Me -->
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
          <a href="{{Route('home.signin')}}" class="small">
            Belum Memiliki akun? daftar
          </a>
        </p>
      </div>
    </div>
  </div>


</body>
</html>
