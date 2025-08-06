@extends('layouts.penerima')

@section('title', 'Donasi')

@section('custom_css')
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
.text-gray-400 {
    color: #6c757d;
}
img {
    max-width: 100%;
    height: auto;
    display: block;
}
@endsection

@section('active-menu-proposal', 'active text-success')

@section('content')
<div class="container mt-3 mb-5">
  <h5 class="fw-bold mt-3 mb-4">Informasi Donasi</h5>
  <div class="table-responsive">
      <table class="table table-bordered text-nowrap mb-0">
        <thead class="table-light">
          <tr>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>No. Resi</th>
            <th>Ekspedisi</th>
            <th>Pengirim</th>
            <th>Penerima</th>
            <th>Asal</th>
            <th>Tujuan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $donationItem->name }}</td>
            <td>{{ $donationItem->quantity }}</td>
            <td>{{ $donationItem->shipment->tracking_number }}</td>
            <td>{{ $donationItem->shipment->deliveryService->name }} ({{ $donationItem->shipment->deliveryService->code }})</td>
            <td>{{ $dataAPI['detail']['shipper'] ?: '-' }}</td>
            <td>{{ $dataAPI['detail']['receiver'] ?: '-' }}</td>
            <td>{{ $dataAPI['detail']['origin'] ?: '-' }}</td>
            <td>{{ $dataAPI['detail']['destination'] ?: '-' }}</td>
          </tr>
        </tbody>
      </table>
  </div>

  <div class="card my-4 shadow-sm">
    <div class="card-body">
        <h3 class="font-weight-bold mb-3">Riwayat Pengiriman</h3>
        <ul class="timeline">
            @foreach ($dataAPI['history'] as $index => $event)
                <li class="mb-2 text-secondary">
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
</div>
@endsection

@section('custom_script')
<script>
// Kosongkan JS bila tidak digunakan
</script>
@endsection
