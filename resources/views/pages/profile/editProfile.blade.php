@extends('layouts.pages')

@section('title', 'Profil')

@section('active-menu-profile', 'active text-primary')

@section('content')
<div class="container mt-4">
    <form action="">
        <div class="my-2">
            <label for="" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" value="{{ Auth::user()->name }}">   
        </div>
        <div class="my-2">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" value="{{ Auth::user()->email }}" disabled>
        </div>

        <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="btn btn-primary">Ubah</button>
        </div>
    </form>
</div>

@endsection

@section('custom_script')

@endsection