@extends('layouts.admin')

@section('title', 'Edit User')

@section('active-menu-users', 'active')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
</div>

<form method="POST" action="{{ route('admin.updateUser', $user->id) }}" class="p-4 border rounded shadow-sm bg-white">
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
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->profile->name) }}" required>
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" readonly>
    </div>

    {{-- Nomor Telepon --}}
    <div class="mb-3">
        <label for="phone_number" class="form-label">Nomor Telepon (Whatsapp)</label>
        <input type="text" id="phone_number" name="phone_number" class="form-control rounded-4 p-3" value="{{ old('phone_number', $user->profile->phone_number) }}" required>
        @error('phone_number')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Alamat --}}
    <div class="mb-3">
        <label for="address">Alamat Lengkap</label>
        <textarea id="address" name="address" class="form-control rounded-4 p-3 mt-2" required>{{ old('address', $user->profile->address) }}</textarea>
        @error('address')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Peran --}}
    <div class="mb-5">
        <label for="role" class="form-label d-block">Peran</label>
        <select name="role" id="role" class="form-control w-100" required>
            <option value="" disabled>Pilih Peran</option>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="penerima" {{ $user->role === 'penerima' ? 'selected' : '' }}>Penerima</option>
            <option value="donatur" {{ $user->role === 'donatur' ? 'selected' : '' }}>Donatur</option>
        </select>
        @error('role')
            <small class="text-danger d-block mt-1">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100">Ubah</button>
</form>

@endsection

@section('custom_js')

@endsection
