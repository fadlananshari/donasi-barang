@extends('layouts.admin')

@section('title', 'Barang Donasi')

@section('custom_css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('active-menu-donation-items', 'active')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tabel Barang Donasi</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('failed'))
    <div class="alert alert-danger">
        {{ session('failed') }}
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Donatur</th>
                        <th>Proposal Donasi</th>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Ekspedisi</th>
                        <th>No. Resi</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donationItems as $item)
                        <tr>
                            <td>{{ $item->profile->name ?? '-' }}</td>
                            <td>{{ $item->donationProposal->title ?? '-' }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->shipment->deliveryService->name ?? '-' }}</td>
                            <td>{{ $item->shipment->tracking_number }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td class="d-flex">
                                <a href="{{ route('admin.editDonationItem', $item->id) }}" class="btn btn-warning mx-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.deleteDonationItem', $item->id) }}" method="POST" class="mx-1" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
