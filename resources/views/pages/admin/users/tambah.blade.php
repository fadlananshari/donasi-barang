@extends('layouts.admin')

@section('title', 'Tambah User')

@section('active-menu-users', 'active')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah User</h1>
</div>

<form method="POST" class="p-4 border rounded shadow-sm bg-white">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Nama Lengkap --}}
    <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi</label>
        <input type="password" class="form-control" name="password" id="password" required>
        @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Konfirmasi Password --}}
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
    </div>

     {{-- Nomor Telepon --}}
     <div class="mb-3">
        <label for="phone_number" class="form-label">Nomor Telepon (Whatsapp)</label>
        <input type="text" id="phone_number" name="phone_number" class="form-control rounded-4 p-3 " required/>
        @error('phone_number')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Address --}}
    <div class="mb-3">
        <label for="address">Alamat Lengkap</label>
        <textarea id="address" name="address" class="form-control rounded-4 p-3 mt-2" required></textarea>
        @error("address")
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-5">
        <label for="role" class="form-label d-block">Peran</label>
        <select name="role" id="role" class="form-control w-100" required>
            <option value="" disabled selected>Pilih Peran</option>
            <option value="admin">Admin</option>
            <option value="penerima">Penerima</option>
            <option value="donatur">Donatur</option>
        </select>        
        @error('role')
            <small class="text-danger d-block mt-1">{{ $message }}</small>
        @enderror
    </div>    

    <button type="submit" class="btn btn-primary w-100">Simpan</button>
</form>

                
@endsection

@section('custom_js')

@endsection