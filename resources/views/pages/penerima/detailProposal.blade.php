@extends('layouts.penerima')

@section('title', 'Donasi')

{{-- @section('custom_body_class', 'bg-secondary') --}}

@section('custom_link')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .modal-bottom .modal-content {
      border-top-left-radius: 1rem;
      border-top-right-radius: 1rem;
      margin-top: auto;
    }

</style>
  
@endsection

@section('active-menu-proposal', 'active text-success')

@section('content')
<div class="container mt-1 mb-5">
    <div class="mx-lg-5">
        <img src="{{asset('storage/' . $proposal->image_campaign)}}" alt="" class="img-fluid w-100">
    </div>
    <h1 class="mt-4 fs-1 fw-bold text-center">
        {{$proposal->title}}
    </h1>

    <div class="d-flex justify-content-between mt-4">
        <div class="text-center">
            <p class="m-0">Terkumpul</p>
            <p class="small fw-bold">{{$proposal->donated_quantity}} Barang</p>
        </div>
        <div class="text-center">
            <p class="m-0">Dibutuhkan</p>
            <p class="small fw-bold">{{$proposal->total_quantity}} Barang</p>
        </div>
    </div>
    <div class="progress mb-3" style="height: 3px;">
        <div class="progress-bar bg-success" role="progressbar" style="width: {{$proposal->donation_percent}}%;" aria-valuenow="{{$proposal->donation_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <div class="mt-4">
        <p class="fw-semibold">Penggalang Barang</p>
        <p class="m-0">{{$proposal->user->name}}</p>
    </div>

    <div class="mt-4">
        <p class="fw-semibold">Cerita Singkat</p>
        <p class="m-0">{{$proposal->story}}</p>
    </div>

    <div class="mt-4">
        <p class="fw-semibold">Detail Kebutuhan</p>
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Detail</th>
                        <th>Kebutuhan</th>
                        <th>Donasi</th>
                        <th>Kurang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proposal->proposalItems as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->detail ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            {{ $donatedGroupedByName[$item->name] ?? 0 }}
                        </td>
                        <td>{{ $item->quantity - ($donatedGroupedByName[$item->name] ?? 0)}}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
    

    <div class="mt-4 row">
        <div class="col-12 col-lg-6">
            <p class="fw-semibold">Dokumen terkait</p>
            <img src="{{asset('storage/' . $proposal->image_letter)}}" alt="" class="img-fluid d-block mx-auto">
        </div>
        <div class="col-12 col-lg-6">
            <p class="fw-semibold mb-0 mt-4">Nomor Dokumen</p>
            <p>{{$proposal->letter_number}}</p>
    
            <div class="alert alert-warning" role="alert">
                <p class="m-0">Pastikan nomor dokumen sesuai dengan yang ada pada gambar dokumen.</p>
            </div>
        </div>
    
        {{-- <p>Nomor Dokumen berbeda? atau proposal mencurigakan? <a href="{{ route('donatur.lapor', $proposal->id) }}">Laporkan disini</a></p> --}}
    </div> 

    <div class="mt-4">
        <p class="fw-semibold ">Barang donasi</p>
        @if ($donationItems->isNotEmpty())
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Donatur</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donationItems as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->profile->name }}</td>
                        <td><a href="{{route('penerima.detailDonasi', $item->id)}}" class="btn btn-success">Detail</a></td>
                    </tr>
                    @endforeach
            </table>
        @else
            <div class="mt-3 mb-5">
                <p class="text-center small text-secondary">Belum ada donasi</p>
            </div>
        @endif
    </div>

    <div class="mt-4">
        @if ($proposal->status == 1)
            <div class="d-flex justify-content-between">
                <p class="fw-semibold m-0 my-auto">Status: <span class="text-success fw-semibold">Aktif</span></p>
                <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Nonaktifkan</button>
            </div>
        @else
            <p class="fw-semibold">Status: <span class="text-danger">Nonaktif</span></p>
        @endif
        <div class="alert alert-warning mt-3" role="alert">
            Jika status <span class="text-success fw-semibold">Aktif</span> maka proposal akan ditampilkan di halaman donatur.
            Sebaliknya, jika status <span class="text-danger fw-semibold">Nonaktif</span> maka proposal tidak akan ditampilkan di halaman donatur
        </div>
    </div>
   
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Apakah anda yakin ingin menonaktifkan proposal?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Klik "Nonaktifkan" untuk menonaktifkan proposal</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Batal</button>
                <form id="logout-form" action="{{ route('penerima.nonaktifStatus', $proposal->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Nonaktifkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_script')
<script>

</script>
@endsection