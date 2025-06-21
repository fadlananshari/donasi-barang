@extends('layouts.pages')

@section('title', 'Home')

{{-- @section('custom_body_class', 'bg-secondary') --}}

@section('active-menu-home', 'active text-primary')

@section('content')
<div class="container mt-4">
    <h5 class="">Halo, 
    @auth
        {{ Auth::user()->name }}
    @endauth !</h5>

    <div class="mt-3 p-3 bg-primary bg-opacity-75 text-white rounded-3">
        <p class="fw-semibold">Yuk, mulai harimu dengan satu kebaikan kecil!</p>
        <div class="d-flex gap-5 text-center px-4">
            <a href='#' class="text-white text-decoration-none">
                <i class="bi bi-archive-fill fs-4"></i><br><small class="m-0">Donasi</small>
            </a>
            <a href='#' class="text-white text-decoration-none">
                <i class="bi bi-bag-fill fs-4"></i><br><small class="m-0">Galang Barang</small>
            </a>
        </div>
    </div>
    
    <div class="mt-4">
        <p class="fw-semibold">Penggalangan Barang Terbaru</p>
        <div>

        </div>
    </div>
    
</div>
@endsection