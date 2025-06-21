@extends('layouts.admin')

@section('title', 'Tambah Ekspedisi')

@section('active-menu-couriers', 'active')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Ekspedisi</h1>
</div>

<form action="{{ route('admin.storeDeliveryService') }}" method="POST" class="p-4 border rounded shadow-sm bg-white">
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

    {{-- Nama Ekspedisi --}}
    <div class="mb-3">
        <label for="name" class="form-label">Nama Ekspedisi</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Kode Ekspedisi --}}
    <div class="mb-5">
        <label for="code" class="form-label">Kode Ekspedisi</label>
        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
        @error('code')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100">Simpan</button>
</form>

@endsection

@section('custom_js')

@endsection
