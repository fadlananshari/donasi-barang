@extends('layouts.penerima')

@section('title', 'Home')

{{-- @section('custom_body_class', 'bg-secondary') --}}

@section('active-menu-proposal', 'active text-success')

@section('content')
<div class="container mt-4">
    <div class="d-sm-flex align-items-center justify-content-between">
        <h2 class="fw-bold text-success">Proposal Donasi</h5>
        <a href="{{route('penerima.tambahProposal')}}" class="btn btn-success">Tambah</a>
    </div>
    
    <div class="row mt-4 gy-2 gx-4">
        @if ($proposals->isNotEmpty())
            @foreach ($proposals as $proposal)
                <div class="col-xl-6">
                    <a href="{{route('penerima.detailProposal', $proposal->id)}}" class="mb-4 card flex-row border px-0 overflow-hidden text-decoration-none w-auto" style="max-height: 170px; width: max-content;">
                        <div class="col-5 h-100">
                            <img 
                                src="{{asset('storage/' . $proposal->image_campaign)}}" 
                                alt="Gambar" 
                                class="img-fluid h-100 w-100 object-fit-cover"
                                style="object-fit: cover; object-fit: cover;"
                            >
                        </div>
                        
                        <div class="col-7 my-auto p-2 rounded-end">
                            <p class="card-title fw-bold m-0">{{$proposal->title}}</p>
                            <p class="card-text text-muted small mb-2 mb-md-3" style="font-size: 12px">
                                {{$proposal->user->name}}
                            </p>
                            <div class="progress mb-2 mb-md-3" style="height: 3px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$proposal->donation_percent}}%;" aria-valuenow="{{$proposal->donation_percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="small m-0 text-muted" style="font-size: 12px">Dibutuhkan</p>
                                    <p class="small fw-semibold" style="font-size: smaller">
                                        {{$proposal->total_quantity}} Barang
                                    </p>
                                </div>
                                <div>
                                    <p class="small m-0 text-muted" style="font-size: 12px">Terkumpul</p>
                                    <p class="small fw-semibold" style="font-size: smaller">{{$proposal->donated_quantity}} Barang</p>
                                </div>
                            </div>                     
                            
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <div class="mt-5">
                <p class="text-center small text-secondary">Belum ada proposal</p>
            </div>
        @endif
    </div>
    
</div>
@endsection