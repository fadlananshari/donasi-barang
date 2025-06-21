@extends('layouts.donatur')

@section('title', 'Home')

{{-- @section('custom_body_class', 'bg-secondary') --}}

@section('active-menu-donate', 'active text-success')

@section('content')
<div class="container mt-4 mb-5">
    <img src="{{asset('storage/' . $proposal->image_campaign)}}" alt="" class="img-fluid">
    <h5 class="mt-4 fw-bold">{{$proposal->title}}</h5>

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
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                        <td>{{ $item->quantity - ($donatedGroupedByName[$item->name] ?? 0) . " lagi" }}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
    

    <div class="mt-4">
        <p class="fw-semibold">Dokumen terkait</p>
        <img src="{{asset('storage/' . $proposal->image_letter)}}" alt="" class="img-fluid">
        <p class="fw-semibold mb-0 mt-4">Nomor Dokumen</p>
        <p>{{$proposal->letter_number}}</p>
    
        <p>Pastikan Nomor Dokumen Sesuai Dengan Yang Ada Pada Gambar Dokumen</p>
        <p>Nomor Dokumen berbeda? Laporkan disini</p>
    </div>

    <div class="row px-2 g-2">
        <div class="col-4">
            <button class="btn btn-outline-success w-100">Bagikan</button>
        </div>
        <div class="col-8">
            <a href="{{ route('donatur.donasi', $proposal->id) }}" class="btn btn-success w-100">Donasi Sekarang</a>
        </div>
    </div>
    


</div>
@endsection

@section('custom_script')
<script>

</script>
@endsection