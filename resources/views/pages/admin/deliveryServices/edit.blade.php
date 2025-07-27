@extends('layouts.admin')

@section('title', 'Edit Ekspedisi')

@section('active-menu-deliveryServices', 'active')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Ekspedisi</h1>
</div>

<form method="POST" action="{{ route('admin.updateDeliveryService', $deliveryService->id) }}" class="p-4 border rounded shadow-sm bg-white">
    @csrf

    {{-- Nama Ekspedisi --}}
    <div class="mb-3">
        <label for="name" class="form-label">Nama Ekspedisi</label>
        <input type="text" name="name" id="name" value="{{ $deliveryService->name }}" class="form-control" required>
    </div>

    {{-- Kode Ekspedisi --}}
    <div class="mb-3">
        <label for="code" class="form-label">Kode Ekspedisi</label>
        <input type="text" name="code" id="code" value="{{ $deliveryService->code }}" class="form-control" required>
    </div>

    {{-- Status --}}
    <div class="mb-5">
        <label for="status" class="form-label d-block">Status</label>
        <select name="status" id="status" class="form-control w-100" required>
            <option value="1" {{ $deliveryService->status == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $deliveryService->status == 0 ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary w-100">Ubah</button>
</form>

@endsection

@section('custom_js')


@endsection
