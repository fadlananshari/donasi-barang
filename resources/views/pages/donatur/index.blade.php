@extends('layouts.donatur')

@section('title', 'Beranda')

@section('active-menu-home', 'active text-success')

@section('custom_css')
.hover-shadow {
  box-shadow: 0 3px 3px rgba(0, 0, 0, 0.18);
  transition: box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1), transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-shadow:hover {
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
  transform: translateY(-4px);
}

@endsection

@section('content')
<section class="py-5">
    <div class="container">
      {{-- HERO --}}
      <div class="row align-items-center mb-5 mx-3">
        <div class="col-md-5 mb-4 mb-md-0" data-aos="fade-right">
          <img src="{{ asset('img/login.png') }}" alt="Donasi Ilustrasi" class="img-fluid" />
        </div>
        <div class="col-md-6" data-aos="fade-left">
          <h1 class="display-5 fw-bold mb-3">Donasi Barang Jadi Lebih Mudah di <span class="text-success">BarangKita</span></h1>
          <p class="text-muted mb-4">BarangKita menghubungkan kebaikanmu dengan mereka yang membutuhkan. Mulai berdonasi sekarang dan bantu mereka yang kurang beruntung.</p>
          <a href="{{ route('donatur.proposal') }}" class="btn btn-success btn-lg px-4">Donasi Sekarang</a>
        </div>
      </div>
  
      {{-- FITUR UTAMA --}}
      <div class="text-center my-5 py-5 bg-success bg-opacity-10 px-5">
        <h2 class="fw-bold mb-4">Apa Saja Fitur Utama <span class="text-success">BarangKita</span>?</h2>
        <div class="row g-4 mt-4">
          @php
            $features = [
              ['icon' => 'box-seam', 'title' => 'Donasi Barang', 'desc' => 'Sumbangkan barang seperti pakaian, buku, alat sekolah, dan lainnya dengan mudah.'],
              ['icon' => 'search', 'title' => 'Lihat Proposal', 'desc' => 'Temukan lembaga atau individu yang mengajukan kebutuhan barang.'],
              ['icon' => 'eye', 'title' => 'Pantau Donasi', 'desc' => 'Lihat progres pengumpulan dan distribusi barang secara real-time.'],
            ];
          @endphp
          @foreach($features as $feature)
            <div class="col-md-4">
              <div class="bg-white border-0 rounded-4 shadow-sm h-100 p-4 text-center" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                <i class="bi bi-{{ $feature['icon'] }} text-success fs-1 mb-3"></i>
                <h5 class="fw-semibold mb-2">{{ $feature['title'] }}</h5>
                <p class="text-muted small">{{ $feature['desc'] }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>
  
      {{-- CARA DONASI --}}
      <section class="py-5 position-relative">
          <div class="container mb-5">
              <h2 class="text-center fw-bold mb-5">Cara Donasi Barang</h2>
          
              @php
                  $steps = [
                  ['icon' => 'file-earmark-text', 'title' => 'Pilih Proposal', 'desc' => 'Telusuri daftar proposal dan pilih kebutuhan yang ingin kamu bantu.'],
                  ['icon' => 'box-seam', 'title' => 'Kirim Barang', 'desc' => 'Kemas barang sesuai kebutuhan dan kirim ke alamat yang tertera di proposal.'],
                  ['icon' => 'clipboard-check', 'title' => 'Isi Formulir', 'desc' => 'Laporkan pengiriman melalui formulir donasi untuk verifikasi.'],
                  ['icon' => 'eye', 'title' => 'Pantau Donasi', 'desc' => 'Lacak status dan dampak dari donasimu secara langsung.'],
                  ];
              @endphp
          
              <div class="row g-4 justify-content-center">
                  @foreach($steps as $index => $step)
                  <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card h-100 border-0 rounded-4 text-center p-4 bg-white hover-shadow" data-aos="fade-up">
                      <div class="text-success fs-1 mb-3">
                          <i class="bi bi-{{ $step['icon'] }}"></i>
                      </div>
                      <h6 class="fw-bold mb-2">{{ $step['title'] }}</h6>
                      <p class="text-muted small">{{ $step['desc'] }}</p>
                    </div>
                  </div>
                  @endforeach
              </div>
          </div>
      </section>
    
      {{-- CTA --}}
      <div class="text-center mt-5 py-5 bg-success bg-opacity-10" data-aos="fade-up">
          <h3 class="fw-bold text-success">Ayo Berdonasi, Sekarang!</h3>
          <p class="text-muted mb-4">Barang tak terpakai di rumahmu bisa jadi harapan baru bagi mereka yang membutuhkan.  
          Mulai donasimu hari ini dan wujudkan kebaikan nyata!</p>
          <a href="{{ route('donatur.proposal') }}" class="btn btn-success px-4 py-2">Donasi Sekarang</a>
      </div>
  
    </div>
  </section>

@endsection
