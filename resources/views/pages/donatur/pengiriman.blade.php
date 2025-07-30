@extends('layouts.donatur')

@section('title', 'Pengiriman')
@section('active-menu-delivery', 'active text-success')

@section('content')
<div class="container mt-3">
    <h2 class="mb-4 fw-bold text-center">Daftar Barang Donasi Kamu</h2>

    <div class="row">
        @forelse ($donationItems as $item)
            @php
                $proposal = $item->donationProposal;
                $profile = $item->profile;
                $shipment = $item->shipment;
                $deliveryService = $shipment->deliveryService ?? null;

                $latest = $trackingData[$item->id]['history'][0] ?? null;
                $status = $trackingData[$item->id]['summary']['status'] ?? null;
            @endphp

            <a href="{{ route('donatur.detailPengiriman', $item->id) }}" 
               class="col-12 col-md-6 mb-3 text-decoration-none" 
               aria-label="Lihat detail pengiriman untuk {{ $item->name }}">
                <div class="card h-100 border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h3 class="h5 card-title fw-semibold">
                                {{ Str::limit($proposal->title, 40) }}
                            </h3>

                            @if ($status)
                                @php
                                    $colorClass = match(strtolower($status)) {
                                        'delivered' => 'text-success',
                                        'on process' => 'text-warning',
                                        'hilang' => 'text-danger',
                                        default => 'text-secondary'
                                    };
                                @endphp
                                <small class="m-0 {{ $colorClass }} text-capitalize">
                                    {{ strtolower($status) }}
                                </small>
                            @endif
                        </div>
                    
                        <div class="row align-items-center">
                            <div class="col-5">
                                <img 
                                    src="{{ asset('storage/' . $proposal->image_campaign) }}" 
                                    alt="Gambar Proposal: {{ $proposal->title }}"
                                    class="img-fluid rounded"
                                    width="300" height="200"
                                    fetchpriority="high"
                                >
                            </div>
                            <div class="col-7">
                                <p class="mb-2 fw-semibold">{{ $item->name }}</p>
                                <p class="m-0 small text-muted">x {{ $item->quantity }} barang</p>
                            </div>
                        </div>

                        @if ($latest)
                            <div class="alert alert-success border-0 mt-3 mb-0">
                                <p class="m-0 text-dark">
                                    <span class="fw-semibold">Status terbaru:</span> {{ $latest['desc'] }}
                                </p>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($latest['date'])->format('d M Y H:i') }}
                                </small>
                            </div>                        
                        @else
                            <div class="alert alert-warning mt-3 text-dark">
                                Status pengiriman tidak tersedia.
                            </div>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="mt-5">
                <p class="text-center small text-muted">Belum ada barang donasi</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
