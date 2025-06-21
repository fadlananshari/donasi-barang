@extends('layouts.admin')

@section('title', 'Data Pengiriman')

@section('custom_css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('active-menu-shipments', 'active')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tabel Pengiriman</h1>
</div>

<!-- Data Table -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Donatur</th>
                        <th>Judul Proposal</th>
                        <th>Jumlah Barang</th>
                        <th>Jasa Pengiriman</th>
                        <th>Nomor Resi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shipments as $shipment)
                        <tr>
                            <td>{{ $shipment->donationItem->profile->name ?? '-' }}</td>
                            <td>{{ $shipment->donationItem->donationProposal->title ?? '-' }}</td>
                            <td>{{ $shipment->donationItem->quantity ?? '-' }}</td>
                            <td>{{ $shipment->deliveryService->name ?? '-' }}</td>
                            <td>{{ $shipment->tracking_number }}</td>
                            <td class="d-flex">
                                <a href="{{ route('admin.detailShipment', $shipment->id) }}" class="btn btn-primary">
                                    Detail
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('custom_js')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
