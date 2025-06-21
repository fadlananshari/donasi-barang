@extends('layouts.admin')

@section('title', 'Proposal Donasi')

@section('custom_css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('active-menu-donation-proposals', 'active')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tabel Proposal Donasi</h1>
    <a href="{{ route('admin.tambahProposal') }}" class="btn btn-success">Tambah</a>
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
                        <th>Judul</th>
                        <th>Gambar</th>
                        <th>Jenis Donasi</th>
                        <th>Daftar Barang</th>
                        <th>Cerita</th>
                        <th>Penerima</th>
                        <th>Dibuat</th>
                        <th>Surat</th>
                        <th>Nomor Surat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proposals as $proposal)
                        <tr>
                            <td>{{ $proposal->title }}</td>
                            <td>
                                @if($proposal->image_campaign)
                                    <img src="{{ asset('storage/' . $proposal->image_campaign) }}" alt="gambar" width="60">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $proposal->donationType->name }}</td>
                            <td>
                                @if ($proposal->proposalItems->count())
                                    <ul class="pl-3 mb-0">
                                        @foreach ($proposal->proposalItems as $item)
                                            <li>{{ $item->name }} ({{ $item->quantity }}) : {{ $item->detail ?? '-' }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Tidak ada barang</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($proposal->story, 50) }}</td>
                            <td>{{ $proposal->user->name }}</td>
                            <td>{{ $proposal->created_at->format('d M Y') }}</td>
                            <td>
                                @if($proposal->image_letter)
                                    <img src="{{ asset('storage/' . $proposal->image_letter) }}" alt="gambar" width="60">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $proposal->letter_number }}</td>
                            <td>
                                @if ($proposal->status)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex mb-2">
                                    <a href="{{ route('admin.editProposal', $proposal->id) }}" class="btn btn-warning mx-1"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.deleteProposal', $proposal->id) }}" method="POST" class="mx-1">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                                @if ($proposal->status)
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.tambahDonationItems', $proposal->id) }}" class="btn btn-primary">Donasi</a>
                                    </div>
                                @endif 
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
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
@endsection
