@extends('layouts.donatur')

@section('title', 'Laporan')

{{-- @section('custom_body_class', 'bg-secondary') --}}

@section('active-menu-donate', 'active text-success')

@section('content')
<div class="container mt-3 mb-5">
    <div class="mx-lg-5">
        <img src="{{ asset('storage/' . $proposal->image_campaign) }}" alt="{{$proposal->title}}" class="img-fluid w-100">
    </div>
    <h1 class="mt-3 fs-1 text-center fw-semibold">Laporkan "{{$proposal->title}}"</h1>

    <form action="{{ route('donatur.storeLaporan', $id) }}" class="mt-4" method="POST" enctype="multipart/form-data">
        @csrf
        
        <input type="hidden" id="id_donation_proposal" name="id_donation_proposal" value="{{$proposal->id}}">
        <input type="hidden" id="id_profile" name="id_profile" value="{{$profile->id}}">

        <!-- Input Alasan -->
        <div class="mb-3">
            <label for="reason" class="form-label">Alasan</label>
            <input class="form-control" id="reason" name="reason" placeholder="Tuliskan alasan Anda..." required>
        </div>

        <!-- Input Alasan -->
        <div class="mb-3">
            <label for="reason" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Tuliskan deskripsi detail dari alasan Anda..." required></textarea>
        </div>
    
        <!-- Upload Bukti Gambar -->
        <div class="mb-5">
            <label for="image" class="form-label">Upload Bukti Gambar</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
        </div>
    
        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-success w-100">Kirim</button>
    </form>
    
</div>
@endsection

@section('custom_script')

@endsection