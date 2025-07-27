@extends('layouts.donatur')

@section('title', 'Pengiriman')

@section('active-menu-delivery', 'active text-success')

@section('content')
<div class="container mt-3">
    <h2 class="mb-4 fw-bold text-center">Daftar Barang Donasi Kamu</h1>

    <div class="row">
        @forelse ($donationItems as $item)
            @php
                $proposal = $item->donationProposal;
                $profile = $item->profile;
                $shipment = $item->shipment;
                $deliveryService = $shipment->deliveryService ?? null;

                $latest = null;
                if (isset($trackingData[$item->id]['history'][0])) {
                    $latest = $trackingData[$item->id]['history'][0];
                }

                $status = null;
                if (isset($trackingData[$item->id]['summary']['status'])) {
                    $status = $trackingData[$item->id]['summary']['status'];
                }

            @endphp

            <a href="{{route('donatur.detailPengiriman' , $item->id)}}" class="col-6 mb-3 text-decoration-none">
                <div class="card h-100 border-0 shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="">
                                <h5 class="card-title fw-semibold">{{ Str::limit($proposal->title, 40)}}</h5>
                            </div>
                            <div class="">
                                    @if ($status == 'DELIVERED')
                                        <small class="m-0 text-success text-capitalize">
                                            {{ strtolower($status)  }}
                                        </small>
                                    @endif

                                    @if ($status == 'ON PROCESS')
                                        <small class="m-0 text-warning text-capitalize">
                                            {{ strtolower($status)  }}
                                        </small>

                                    @endif

                                    @if ($status == 'HILANG')
                                        <small class="m-0 text-danger text-capitalize">
                                            {{ strtolower($status)  }}
                                        </small>
                                    @endif                           
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-5">
                                <img src="{{ asset('storage/' . $proposal->image_campaign) }}" alt="Gambar Proposal" class="img-fluid rounded">
                            </div>
                            <div class="col-7 my-auto">
                                <p class="mb-2">{{ $item->name }}</p>
                                <p class="m-0 small text-secondary">x {{ $item->quantity }} barang</p>
                            </div>
                        </div>

                        @if ($latest)
                            <div class="alert alert-success border-0 mt-3 mb-0 d-block text-decoration-none">
                                <p class="m-0 text-success"><span class="fw-semibold">Status terbaru:</span> {{ $latest['desc'] }}</p>
                                <small class="text-muted text-success">{{ \Carbon\Carbon::parse($latest['date'])->format('d M Y H:i') }}</small>
                            </div>                        
                        @else
                            <div class="alert alert-warning mt-3 text-warning">Status pengiriman tidak tersedia.</div>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="mt-5">
                <p class="text-center small text-secondary">Belum ada barang donasi</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('custom_script')
<script>
// Jika ingin menambahkan script, masukkan di sini
</script>
@endsection
