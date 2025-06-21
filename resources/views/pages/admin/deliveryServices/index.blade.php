@extends('layouts.admin')

@section('title', 'Ekspedisi')

@section('custom_css')

    <!-- Custom styles for this page -->
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

@endsection

@section('active-menu-deliveryServices', 'active')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tabel Ekspedisi</h1>
    <a href="{{ route('admin.tambahDeliveryService') }}" class="btn btn-success">Tambah</a>
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

<!-- Data Table -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Ekspedisi</th>
                        <th>Kode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveryServices as $deliveryService)
                        <tr>
                            <td>{{ $deliveryService->name }}</td>
                            <td>{{ $deliveryService->code }}</td>
                            <td>
                                @if ($deliveryService->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="d-flex">
                                <a href="{{ route('admin.editDeliveryService', $deliveryService->id )}}" class="btn btn-warning mx-1"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.deleteDeliveryService', $deliveryService->id )}}" method="post" class="mx-1">
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>

@endsection