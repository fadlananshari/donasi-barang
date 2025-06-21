<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign In - BarangKita</title>
  <link rel="icon" type="image/png" href="{{ asset('img/logo-barangkita.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        font-family: "Spline Sans", "Noto Sans", sans-serif;
        background-color: #f8fafc;
      }
  </style>
</head>
<body class="bg-light">
  <div class="">
      <div class="card shadow pt-4 px-5 mx-auto" style="max-width: 500px; min-height: 100vh;">
          <div class="d-flex align-items-center justify-content-between mb-3">
              <h2 class="text-center flex-grow-1 fw-semibold">Registrasi</h2>
          </div>
      
            <form method="POST" action="{{ route('register.submit') }}">
              @csrf
      
              {{-- Nama Lengkap --}}
              <div class="mb-3">
                  <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" class="form-control rounded-4 p-3 bg-light border-0" required/>
                  @error('name')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
      
              {{-- Email --}}
              <div class="mb-3">
                  <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email" class="form-control rounded-4 p-3 bg-light border-0" required/>
                  @error('email')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
      
              {{-- Password --}}
              <div class="mb-3">
                  <input type="password" name="password" id="password" placeholder="Password" class="form-control rounded-4 bg-light p-3 border-0" required/>
                  @error('password')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
      
              {{-- Konfirmasi Password --}}
              <div class="mb-3">
                  <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" class="form-control rounded-4 bg-light p-3 border-0" required/>
              </div>
      
              {{-- Nomor Telepon --}}
              <div class="mb-3">
                  <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="Nomor Handphone (Whatsapp)" class="form-control rounded-4 p-3 bg-light border-0" required/>
                  @error('phone_number')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
      
              {{-- Address --}}
              <div class="mb-3">
                  <label for="address">Alamat Lengkap</label>
                  <textarea id="address" name="address" value="{{ old("address") }}" class="form-control bg-light rounded-4 p-3 mt-2" required></textarea>
                  @error("address")
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
      
              {{-- Role --}}
              <div class="mb-3">
                  <label class="form-label d-block">Daftar Sebagai</label>
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="role" id="donatur" value="donatur" {{ old('role') == 'donatur' ? 'checked' : '' }} required>
                      <label class="form-check-label" for="donatur">Donatur</label>
                  </div>
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="role" id="penerima" value="penerima" {{ old('role') == 'penerima' ? 'checked' : '' }}>
                      <label class="form-check-label" for="penerima">Penerima</label>
                  </div>
                  @error('role')
                      <small class="text-danger d-block mt-1">{{ $message }}</small>
                  @enderror
              </div>
      
              {{-- Tombol Submit --}}
              <div class="d-grid mb-3">
                <button class="btn btn-success rounded-pill" type="submit">Daftar</button>
              </div>
      
              {{-- Link ke login --}}
              <p class="text-center small"><a href="{{ route('login') }}">Sudah memiliki akun? masuk</a></p>
            </form>
          
        </div>
  </div>

  <script>
    const form = document.querySelector('form');
    const password = document.querySelector('#password');
    const confirmPassword = document.querySelector('#password_confirmation');
  
    form.addEventListener('submit', function (e) {
      if (password.value !== confirmPassword.value) {
        e.preventDefault();
        alert('Kata sandi dan konfirmasi kata sandi tidak sama.');
      }
    });
  </script>
  
</body>
</html>
