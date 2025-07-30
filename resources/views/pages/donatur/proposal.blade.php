@extends('layouts.donatur')

@section('title', 'Proposal')

@section('active-menu-donate', 'active text-success')

@section('content')
<div class="container py-4">

  {{-- Section: Heading --}}
  <div class="text-center mb-5" data-aos="fade-up">
    <h1 class="fw-bold text-success">Ayo Berdonasi!</h1> <!-- Ganti h2 dengan h1 untuk hierarki heading yang benar -->
    <p class="text-muted">Cari dan pilih jenis barang yang ingin kamu donasikan untuk mereka yang membutuhkan.</p>
  </div>

  {{-- Section: Filter --}}
  <form method="GET" action="" class="row justify-content-center mb-4" data-aos="fade-up">
    <div class="col-md-6 col-lg-4 mb-2">
      <label for="search" class="form-label visually-hidden">Cari berdasarkan nama proposal</label> <!-- Tambahkan label untuk input -->
      <input type="text" name="search" id="search" class="form-control" placeholder="Cari berdasarkan nama proposal..." value="{{ request('search') }}" aria-label="Cari berdasarkan nama proposal">
    </div>
    <div class="col-md-4 col-lg-3 mb-2">
      <label for="type" class="form-label visually-hidden">Pilih Jenis Donasi</label> <!-- Tambahkan label untuk select -->
      <select name="type" id="type" class="form-select" aria-label="Pilih jenis donasi">
        <option value="">Semua Jenis Donasi</option>
        @foreach ($donationType as $type)
          <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
            {{ $type->name }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2 col-lg-2 mb-2 d-grid">
      <button type="submit" class="btn btn-success" aria-label="Cari proposal">Cari</button>
    </div>
  </form>

  <div class="row mt-5 gy-2 gx-4">
    @if ($proposals->isNotEmpty())
        @foreach ($proposals as $proposal)
          <div class="col-xl-6">
            <a href="{{route('donatur.detailProposal', $proposal->id)}}" 
              class="mb-4 card flex-row border px-0 overflow-hidden text-decoration-none w-auto"
              style="height: 170px; width: max-content;" 
              aria-label="Lihat detail proposal {{$proposal->title}}"> <!-- Tambahkan aria-label -->
               
               <div class="col-5 h-100">
                   <img 
                       src="{{asset('storage/' . $proposal->image_campaign)}}" 
                       alt="Gambar proposal {{$proposal->title}}" 
                       class="img-fluid object-fit-cover rounded-start h-100"
                       style="width: 100%; object-fit: cover;">
               </div>
                   <div class="col-7 my-auto p-2 rounded-end">
                    <p class="card-title fw-bold m-0">{{$proposal->title}}</p>
                    <p class="card-text text-muted small mb-2 mb-md-3" style="font-size: 12px">
                        {{$proposal->user->name}}
                    </p>
                    <div class="progress mb-2 mb-md-3" style="height: 3px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$proposal->donation_percent}}%;" aria-valuenow="{{$proposal->donation_percent}}" aria-valuemin="0" aria-valuemax="100" aria-label="Donasi terkumpul {{$proposal->donation_percent}} persen"></div>
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

</div>
@endsection
