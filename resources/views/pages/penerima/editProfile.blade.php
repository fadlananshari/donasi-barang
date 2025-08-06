@extends('layouts.penerima')

@section('title', 'Profil')

@section('active-menu-profile', 'active text-success')

@section('content')
<div class="container mt-3" style="min-height: 600px; overflow-anchor: none;">

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('penerima.updateProfile') }}">
        @csrf

        {{-- Nama Lengkap --}}
        <div class="mb-3">
            <label for="name">Nama Lengkap</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $profile->name) }}"
                placeholder="Nama Lengkap"
                class="form-control rounded-4 p-3 bg-light"
                required
                autocomplete="name"
            >
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                placeholder="Email"
                class="form-control rounded-4 p-3 bg-light"
                readonly
                autocomplete="email"
            >
        </div>

        {{-- Nomor Telepon --}}
        <div class="mb-3">
            <label for="phone_number">Nomor Telepon</label>
            <input
                type="text"
                id="phone_number"
                name="phone_number"
                value="{{ old('phone_number', $profile->phone_number ?? '') }}"
                placeholder="Nomor Handphone (Whatsapp)"
                class="form-control rounded-4 p-3 bg-light"
                required
                inputmode="tel"
                autocomplete="tel"
            >
            @error('phone_number')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Alamat --}}
        <div class="mb-3">
            <label for="address">Alamat Lengkap</label>
            <textarea
                id="address"
                name="address"
                rows="3"
                class="form-control bg-light rounded-4 p-3 mt-2"
                required
                autocomplete="street-address"
            >{{ old('address', $profile->address ?? '') }}</textarea>
            @error('address')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Role --}}
        <div class="mb-3">
            <label class="form-label d-block">Anda Terdaftar Sebagai</label>
            <span class="badge bg-primary text-capitalize">{{ $user->role }}</span>
        </div>

        {{-- Tombol Submit --}}
        <div class="d-grid mb-3 mt-5">
            <button class="btn btn-success" type="submit">Simpan</button>
        </div>
    </form>
</div>
@endsection
