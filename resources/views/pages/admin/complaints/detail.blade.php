@extends('layouts.admin')

@section('title', 'Detail Komplain')

@section('active-menu-complaints', 'active')

@section('content')

<h1 class="mb-4 h3 text-gray-800">Detail Komplain</h1>
<div class="card mb-4">
    <div class="card-header bg-success text-white fw-bold">Informasi Komplain</div>
    <div class="card-body">
        <p><strong>Alasan Komplain:</strong> {{ $complaint->reason }}</p>
        <p><strong>Tanggal Dibuat:</strong> {{ $complaint->created_at->format('d M Y') }}</p>
        <p><strong>Bukti Gambar:</strong></p>
        <img src="{{ asset('storage/' . $complaint->image) }}" alt="Bukti Komplain" class="img-fluid rounded border shadow-sm" style="max-width: 400px;">
    </div>
</div>
<div class="card mb-4">
    <div class="card-header bg-success text-white fw-bold">Informasi Donatur</div>
    <div class="card-body">
        <p><strong>Nama:</strong> {{ $complaint->profile->name }}</p>
        <p><strong>No. HP:</strong> {{ $complaint->profile->phone_number }}</p>
        <p><strong>Alamat:</strong> {{ $complaint->profile->address }}</p>
    </div>
</div>
<div class="card mb-4">
    <div class="card-header bg-success text-white fw-bold">Informasi Proposal Donasi</div>
    <div class="card-body">
        <p><strong>Judul Proposal:</strong> {{ $complaint->proposal->title }}</p>
        <p><strong>Alamat Tujuan:</strong> {{ $complaint->proposal->address }}</p>
        <p><strong>Nomor Surat:</strong> {{ $complaint->proposal->letter_number }}</p>
        <p><strong>Isi Cerita:</strong></p>
        <div class="border rounded p-3 bg-light" style="white-space: pre-line;">
            {{ $complaint->proposal->story }}
        </div>
        <p class="mt-3"><strong>Gambar Kampanye:</strong></p>
        <img src="{{ asset('storage/' . $complaint->proposal->image_campaign) }}" alt="Gambar Kampanye" class="img-fluid rounded border shadow-sm" style="max-width: 400px;">
    </div>
</div>

@endsection
