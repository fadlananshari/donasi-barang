@extends('layouts.donatur')

@section('title', 'Home')

{{-- @section('custom_body_class', 'bg-secondary') --}}

@section('active-menu-donate', 'active text-success')

@section('content')
<div class="container mt-4">
    @foreach ($proposals as $proposal)
        <a href="/donatur/{{$proposal->id}}" class="card mb-4 flex-row border-0 overflow-hidden text-decoration-none" style="max-height: 170px;">
            <div class="col-6">
                <img 
                    src="{{asset('storage/' . $proposal->image_campaign)}}" 
                    alt="Gambar" 
                    class="img-fluid h-100 w-100 object-fit-cover"
                    style="object-fit: cover;"
                >
            </div>
            
            <div class="col-6 p-2">
                <p class="card-title fw-bold small">{{$proposal->title}}</p>
                <p class="card-text text-muted small" style="font-size: 12px">
                    {{$proposal->user->name}}
                </p>
                <div class="progress mb-3" style="height: 3px;">
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
    @endforeach
    
</div>
@endsection

@section('custom_script')
<script>

</script>
@endsection