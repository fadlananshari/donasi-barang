@extends('layouts.donatur')

@section('title', 'Profil')

{{-- @section('custom_body_class', 'bg-secondary') --}}

@section('active-menu-profile', 'active text-success')

@section('content')
<div class="container mt-3">
    <div class="row pt-3 mb-4 gap-2">
        <div class="col-1">
            <i class="bi bi-person-circle display-1 text-secondary"></i>

        </div>
        <div class="col my-auto">
            <p class="fw-bold mb-1 text-success">{{$profile->name}}</p>
            <p class="m-0">{{Auth::user()->email}}</p>
        </div>
    </div>

    <div class="list-group">
        <a href="{{route('donatur.editProfile')}}" class="py-4 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="bi bi-pencil-square me-3 text-success"></i> <!-- Ikon -->
                Edit Profil
            </div>
            <i class="bi bi-chevron-right text-secondary"></i> <!-- Panah kanan -->
        </a>
    
        <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="py-4 list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="bi bi-box-arrow-right me-3 text-danger"></i>
                Keluar
            </div>
            <i class="bi bi-chevron-right text-secondary"></i>
        </button>
    </div>
    
    {{-- <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Keluar</button> --}}
    
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" aria-describedby="modal-description">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Keluar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modal-description">Klik "Keluar" jika Anda ingin mengakhiri sesi Anda.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" aria-label="Batalkan logout">Batal</button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger" aria-label="Konfirmasi logout">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('logout-form');
        form.addEventListener('submit', function(e) {
            console.log('Form submitted');
        });
    });
</script>
@endsection