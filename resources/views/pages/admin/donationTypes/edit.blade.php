@extends('layouts.admin')

@section('title', 'Edit Jenis Donasi')

@section('active-menu-donation-types', 'active')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Jenis Donasi</h1>
</div>

<form method="POST" action="{{ route('admin.updateDonationType', $donationType->id) }}" class="p-4 border rounded shadow-sm bg-white">
    @csrf

    {{-- Nama Jenis Donasi --}}
    <div class="mb-3">
        <label for="name" class="form-label">Nama Jenis Donasi</label>
        <input type="text" name="name" id="name" value="{{ $donationType->name }}" class="form-control" required>
    </div>

    {{-- Status --}}
    <div class="mb-5">
        <label for="status" class="form-label d-block">Status</label>
        <select name="status" id="status" class="form-control w-100" required>
            <option value="1" {{ $donationType->status == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $donationType->status == 0 ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary w-100">Ubah</button>
</form>

@endsection

@section('custom_js')

@endsection
