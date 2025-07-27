@extends('layouts.donatur')

@section('title', 'Donasi')

{{-- @section('custom_body_class', 'bg-secondary') --}}

@section('custom_link')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .modal-bottom .modal-content {
      border-top-left-radius: 1rem;
      border-top-right-radius: 1rem;
      margin-top: auto;
    }

</style>
  
@endsection

@section('active-menu-donate', 'active text-success')

@section('content')
<div class="container mt-1 mb-5">
    <div class="mx-lg-5">
        <img src="{{asset('storage/' . $proposal->image_campaign)}}" alt="" class="img-fluid w-100">
    </div>
    <h1 class="mt-4 fs-1 fw-bold text-center">
        {{ $proposal->title }}
    </h1>

    <div class="d-flex justify-content-between mt-4">
        <div class="text-center">
            <p class="m-0">Terkumpul</p>
            <p class="small fw-bold">{{$proposal->donated_quantity}} Barang</p>
        </div>
        <div class="text-center">
            <p class="m-0">Dibutuhkan</p>
            <p class="small fw-bold">{{$proposal->total_quantity}} Barang</p>
        </div>
    </div>
    <div class="progress mb-3" style="height: 3px;">
        <div class="progress-bar bg-success" role="progressbar" style="width: {{$proposal->donation_percent}}%;" aria-valuenow="{{$proposal->donation_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <div class="mt-4">
        <p class="fw-semibold">Penggalang Barang</p>
        <p class="m-0">{{$proposal->user->name}}</p>
    </div>

    <div class="mt-4">
        <p class="fw-semibold">Cerita Singkat</p>
        <p class="m-0">{{$proposal->story}}</p>
    </div>

    <div class="mt-4">
        <p class="fw-semibold">Detail Kebutuhan</p>
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Detail</th>
                        <th>Kebutuhan</th>
                        <th>Donasi</th>
                        <th>Kurang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proposal->proposalItems as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->detail ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            {{ $donatedGroupedByName[$item->name] ?? 0 }}
                        </td>
                        <td>{{ $item->quantity - ($donatedGroupedByName[$item->name] ?? 0) }}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
    

    <div class="mt-4 row">
        <div class="col-12 col-lg-6">
            <p class="fw-semibold">Dokumen terkait</p>
            <img src="{{asset('storage/' . $proposal->image_letter)}}" alt="" class="img-fluid d-block mx-auto">
        </div>
        <div class="col-12 col-lg-6">
            <p class="fw-semibold mb-0 mt-4">Nomor Dokumen</p>
            <p>{{$proposal->letter_number}}</p>
    
            <div class="alert alert-warning" role="alert">
                <p class="m-0">Pastikan nomor dokumen sesuai dengan yang ada pada gambar dokumen. Nomor dokumen berbeda? atau proposal mencurigakan? <a href="{{ route('donatur.lapor', $proposal->id) }}">Laporkan disini</a></p>
            </div>
        </div>
    
        {{-- <p>Nomor Dokumen berbeda? atau proposal mencurigakan? <a href="{{ route('donatur.lapor', $proposal->id) }}">Laporkan disini</a></p> --}}
    </div>

    <div class="row px-2 g-2">
        <div class="col-4">
            <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#shareModal" onclick="setupShare()">
                <i class="fas fa-share-alt me-1"></i> Bagikan
            </button>              
            
        </div>
        <div class="col-8">
            <a href="{{ route('donatur.donasi', $proposal->id) }}" class="btn btn-success w-100">Donasi Sekarang</a>
        </div>
    </div>

    <!-- Modal Share -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down modal-bottom">
            <div class="modal-content rounded-top">
                <!-- Tombol Close -->
                <div class="d-flex justify-content-end p-2">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
        
                <div class="modal-body pt-0">
        
                    <p class="fw-semibold mb-2">Bagikan lewat</p>
            
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="#" id="share-whatsapp" target="_blank" class="btn btn-success d-flex align-items-center gap-2">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" id="share-facebook" target="_blank" class="btn btn-primary d-flex align-items-center gap-2">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="#" id="share-line" target="_blank" class="btn d-flex align-items-center gap-2 text-white" style="background-color: #00c300;">
                            <i class="fab fa-line"></i> LINE
                        </a>
                        <a href="#" id="share-twitter" target="_blank" class="btn btn-info text-white d-flex align-items-center gap-2">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                    </div>
            
                    <div class="input-group">
                        <input type="text" id="share-url" class="form-control" readonly>
                        <button class="btn btn-outline-secondary" onclick="copyLink()">
                            <i class="fas fa-copy"></i> Salin
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast: Tautan berhasil disalin -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
        <div id="copyToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
            Tautan berhasil disalin
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
        </div>
        </div>
    </div>
  
   
</div>
@endsection

@section('custom_script')
<script>
  function setupShare() {
    const url = window.location.href;

    document.getElementById('share-url').value = url;
    document.getElementById('share-whatsapp').href = `https://wa.me/?text=${encodeURIComponent(url)}`;
    document.getElementById('share-facebook').href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
    document.getElementById('share-line').href = `https://social-plugins.line.me/lineit/share?url=${encodeURIComponent(url)}`;
    document.getElementById('share-twitter').href = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(document.title)}`;

    // Salin otomatis
    navigator.clipboard.writeText(url).catch(() => {});
  }

  function copyLink() {
    const url = document.getElementById('share-url').value;
    navigator.clipboard.writeText(url)
      .then(() => {
        const toast = new bootstrap.Toast(document.getElementById('copyToast'));
        toast.show();
      })
      .catch(() => alert('Gagal menyalin tautan.'));
  }
</script>
@endsection