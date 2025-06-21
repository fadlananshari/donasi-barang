@extends('layouts.donatur')

@section('title', 'Pengiriman')

@section('active-menu-delivery', 'active text-success')

@section('content')
<div class="container mt-4">
    <h5 class="mb-4 text-success fw-bold text-center">Daftar Barang Donasi Kamu</h5>

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

                // dd($status);
            @endphp

            <div class="col-12 mb-3">
                <div class="card h-100 border-0 shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <p class="card-title fw-semibold">{{ $proposal->title }}</p>
                            </div>
                            <div class="">
                                @if ($status)
                                    <small class="m-0 text-success small">
                                        {{$status}}
                                    </small>
                                @endif
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $proposal->image_campaign) }}" alt="Gambar Proposal" class="img-fluid rounded">
                            </div>
                            <div class="col-md-8 my-auto">
                                <p class="m-0">{{ $item->name }}</p>
                                <p class="m-0 text-end small text-secondary">x {{ $item->quantity }} barang</p>
                            </div>
                        </div>

                        @if ($latest)
                            <a href="{{route('donatur.detailPengiriman' , $item->id)}}" class="alert alert-success border-0 mt-3 d-block text-decoration-none">
                                <p class="m-0 text-success"><span class="fw-semibold">Status terbaru:</span> {{ $latest['desc'] }}</p>
                                <small class="text-muted text-success">{{ \Carbon\Carbon::parse($latest['date'])->format('d M Y H:i') }}</small>
                            </a>                        
                        @else
                            <div class="alert alert-warning mt-3">Status pengiriman tidak tersedia.</div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada barang donasi yang kamu kirimkan.</div>
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
