@extends('layouts.admin')

@section('title', 'Daftar Pengaduan')

@section('custom_css')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('active-menu-complaints', 'active')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tabel Komplain</h1>
</div>

@if(session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
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
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Pengadu</th>
                        <th>Proposal</th>
                        <th>Alasan</th>
                        <th>Deskripsi</th>
                        <th>Bukti Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($complaints as $complaint)
                        <tr>
                            <td>{{ $complaint->profile->name ?? '-' }}</td>
                            <td>{{ $complaint->proposal->title ?? '-' }}</td>
                            <td>{{ $complaint->reason }}</td>
                            <td>{{ $complaint->description }}</td>
                            <td>
                                @if($complaint->image)
                                    <a href="{{ asset('storage/' . $complaint->image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $complaint->image) }}" alt="bukti" width="60">
                                    </a>
                                @else
                                    Tidak ada
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.detailComplaints', $complaint->id) }}" class="btn btn-primary">
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

    <script>
        const toastEl = document.querySelector('.toast');
        if (toastEl) {
            const bsToast = new bootstrap.Toast(toastEl, { delay: 3000 });
            bsToast.show();
        }
    </script>
@endsection
