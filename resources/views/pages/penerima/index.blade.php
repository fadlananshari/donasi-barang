@extends('layouts.penerima')

@section('title', 'Home')

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

@section('active-menu-home', 'active text-success')

@section('content')
<section class="py-5">

    <div class="container">
        {{-- HERO --}}
        <div class="row align-items-center mb-5 mx-3">
            <div class="col-md-5 mb-4 mb-md-0" data-aos="fade-right">
            <img src="{{ asset('img/login.png') }}" alt="Donasi Ilustrasi" class="img-fluid" />
            </div>
            <div class="col-md-6" data-aos="fade-left">
            <h1 class="display-5 fw-bold mb-3">Galang Donasi Jadi Lebih Mudah di <span class="text-success">BarangKita</span></h1>
            <p class="text-muted mb-4">BarangKita membantu anda menggalang barang untuk mereka yang membutuhkan. Mulai dari panti asuhan, sekolah hingga korban bencana.</p>
            <a href="{{ route('penerima.tambahProposal') }}" class="btn btn-success btn-lg px-4">Galang Sekarang</a>
            </div>
        </div>
    
        {{-- FITUR UTAMA --}}
        <div class="text-center my-5 py-5 bg-success bg-opacity-10 px-5">
            <h2 class="fw-bold mb-4">Mengapa Menggalang Donasi di <span class="text-success">BarangKita</span>?</h2>
            <div class="row g-4 mt-4">
            @php
                $features = [
                ['icon' => 'check-circle', 'title' => 'Mudah & Cepat', 'desc' => 'Buat proposal penggalangan donasi hanya dalam beberapa langkah mudah.'],
                ['icon' => 'people-fill', 'title' => 'Jangkauan Luas', 'desc' => 'Proposal anda akan dilihat oleh donatur di seluruh Indonesia.'],
                ['icon' => 'transparency', 'title' => 'Laporan Transparan', 'desc' => 'Lacak dan kelola donasi yang masuk dengan mudah melalui website.'],
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
  
        {{-- CARA GALANG DONASI --}}
        <section class="py-5 position-relative">
            <div class="container mb-5">
                <h2 class="text-center fw-bold">Cara Menggalang Donasi</h2>
                <p class="text-center text-gray-600 mb-5">Hanya dengan 3 langkah mudah, Anda sudah bisa memulai kebaikan.</p>
                @php
                    $steps = [
                    ['icon' => 'file-earmark-text', 'title' => 'Buat Proposal', 'desc' => 'Isi formulir penggalangan donasi sesuai dengan kebutuhan anda.'],
                    ['icon' => 'phone', 'title' => 'Sebar Proposal', 'desc' => 'Bagikan proposal Anda ke media sosial untuk menjangkau lebih banyak donatur.'],
                    ['icon' => 'bank', 'title' => 'Terima Donasi', 'desc' => 'Pantau donasi yang masuk dan salurkan kepada yang membutuhkan.'],
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
            <h3 class="fw-bold text-success">Siap Membantu Mereka?</h3>
            <p class="text-muted mb-4">Ayo mulai langkah kebaikanmu sekarang juga! Buat proposal penggalangan donasi dan bantu mereka yang membutuhkan di sekitarmu</p>
            <a href="{{ route('penerima.tambahProposal') }}" class="btn btn-success px-4 py-2">Galang Sekarang</a>
        </div>
    </div>
</div>
@endsection