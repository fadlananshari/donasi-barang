@extends('layouts.donatur')

@section('title', 'Proposal')

@section('active-menu-donate', 'active text-success')

@section('content')
<div class="container py-4">

  {{-- Section: Heading --}}
  <div class="text-center mb-5" data-aos="fade-up">
    <h2 class="fw-bold text-success">Ayo Berdonasi!</h2>
    <p class="text-muted">Cari dan pilih jenis barang yang ingin kamu donasikan untuk mereka yang membutuhkan.</p>
  </div>

  {{-- Section: Filter --}}
  <form method="GET" action="" class="row justify-content-center mb-4" data-aos="fade-up">
    <div class="col-md-6 col-lg-4 mb-2">
      <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama proposal..." value="{{ request('search') }}">
    </div>
    <div class="col-md-4 col-lg-3 mb-2">
      <select name="type" class="form-select">
        <option value="">Semua Jenis Donasi</option>
        @foreach ($donationType as $type)
          <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
            {{ $type->name }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2 col-lg-2 mb-2 d-grid">
      <button type="submit" class="btn btn-success">Cari</button>
    </div>
  </form>

  <div class="row mt-5 gy-2 gx-4">
    @if ($proposals->isNotEmpty())
        @foreach ($proposals as $proposal)
          <div class="col-xl-6">
            <a href="{{route('donatur.detailProposal', $proposal->id)}}" 
              class="mb-4 card flex-row border px-0 overflow-hidden text-decoration-none w-auto"
              style="height: 170px; width: max-content;">
               
               <div class="col-5 h-100">
                   <img 
                       src="{{asset('storage/' . $proposal->image_campaign)}}" 
                       alt="Gambar" 
                       class="img-fluid object-fit-cover rounded-start h-100"
                       style="width: 100%; object-fit: cover;"
                   >
               </div>
                  
                <div class="col-7 my-auto p-2 rounded-end">
                    <p class="card-title fw-bold m-0">{{$proposal->title}}</p>
                    <p class="card-text text-muted small mb-2 mb-md-3" style="font-size: 12px">
                        {{$proposal->user->name}}
                    </p>
                    <div class="progress mb-2 mb-md-3" style="height: 3px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$proposal->donation_percent}}%;" aria-valuenow="{{$proposal->donation_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="small m-0 text-muted" style="font-size: 12px">Dibutuhkan</p>
                            <p class="small fw-semibold" style="font-size: smaller">
                                {{$proposal->total_quantity}} Barang
                            </p>
                        </div>
                        <div>
                            <p class="small m-0 text-muted" style="font-size: 12px">Terkumpul</p>
                            <p class="small fw-semibold" style="font-size: smaller">{{$proposal->donated_quantity}} Barang</p>
                        </div>
                    </div>                     
                </div>
              </a>
          </div>
        @endforeach
    @else
        <div class="mt-5">
            <p class="text-center small text-secondary">Belum ada proposal</p>
        </div>
    @endif
</div>




  {{-- Section: Proposal List --}}
  {{-- <div class="row g-4" data-aos="fade-up">
    @forelse ($proposals as $proposal)
      <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title text-success fw-bold">{{ $proposal->title }}</h5>
            <p class="text-muted small mb-1">Jenis: {{ $proposal->donationType->name }}</p>
            <p class="card-text">{{ Str::limit($proposal->description, 100) }}</p>

            <div class="progress mb-2" style="height: 10px;">
              <div class="progress-bar bg-success" role="progressbar" style="width: {{ $proposal->donation_percent }}%;" aria-valuenow="{{ $proposal->donation_percent }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <p class="small text-muted mb-0">{{ $proposal->donated_quantity }} dari {{ $proposal->total_quantity }} barang telah didonasikan</p>
          </div>
          <div class="card-footer bg-white border-top-0">
            <a href="{{ route('donatur.detailProposal', $proposal->id) }}" class="btn btn-outline-success w-100">Donasi Sekarang</a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center">
        <p class="text-muted">Tidak ada proposal yang tersedia saat ini.</p>
      </div>
    @endforelse
  </div> --}}
</div>
@endsection
