@extends('layouts.admin')

@section('title', 'Detail Pengiriman')

@section('active-menu-shipments', 'active')

@section('content')

<!-- Header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pengiriman</h1>
</div>

<!-- Info Utama -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="font-weight-bold">Informasi Umum</h5>
        <p><strong>No. Resi:</strong> {{ $shipment->tracking_number }}</p>
        <p><strong>Ekspedisi:</strong> {{ $shipment->deliveryService->name }} ({{ $shipment->deliveryService->code }})</p>
        <p><strong>Layanan:</strong> {{ $trackingData['summary']['service'] ?: '-' }} </p>
        <p><strong>Status:</strong> <span class="badge badge-info">{{ $trackingData['summary']['status'] }}</span></p>
        <p><strong>Tanggal Update Terakhir:</strong> {{ $trackingData['summary']['date'] ?: '-' }}</p>
        <p><strong>Pengirim:</strong> {{ $trackingData['detail']['shipper'] ?: '-' }}</p>
        <p><strong>Penerima:</strong> {{ $trackingData['detail']['receiver'] ?: '-' }}</p>
        <p><strong>Asal:</strong> {{ $trackingData['detail']['origin'] ?: '-' }}</p>
        <p><strong>Tujuan:</strong> {{ $trackingData['detail']['destination'] ?: '-' }}</p>
        <p><strong>Berat:</strong> {{ $trackingData['summary']['weight'] ?: '-' }} gr</p>
    </div>
</div>

<!-- Riwayat Pengiriman -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="font-weight-bold mb-3">Riwayat Pengiriman</h5>
        <ul class="timeline">
            @foreach ($trackingData['history'] as $index => $event)
                <li class="mb-2 text-gray-400">
                    <strong class="{{ $index === 0 ? 'text-dark' : '' }}">
                        {{ \Carbon\Carbon::parse($event['date'])->format('d M Y H:i') }}
                    </strong><br>
                    <span class="{{ $index === 0 ? 'text-info' : '' }}">
                        {{ $event['desc'] }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</div>

@endsection

@section('custom_css')
<style>
    .timeline {
        list-style: none;
        padding-left: 0;
        position: relative;
    }
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 10px;
        width: 2px;
        background: #dee2e6;
    }
    .timeline li {
        position: relative;
        padding-left: 30px;
    }
    .timeline li:before {
        content: '';
        position: absolute;
        left: 5px;
        top: 5px;
        width: 10px;
        height: 10px;
        background: #858796;
        border-radius: 50%;
    }
</style>
@endsection
