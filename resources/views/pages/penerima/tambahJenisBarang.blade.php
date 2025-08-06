@extends('layouts.penerima')

@section('title', 'Donasi')

@section('active-menu-proposal', 'active text-success')

@section('content')
<div class="container mt-1 mb-5">
    <form action="{{ route('penerima.storeItemType') }}" method="POST" class="p-4 border rounded shadow-sm bg-white">
        @csrf
    
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        {{-- Nama Tipe Donasi --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama Jenis Barang</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    
        <button type="submit" class="btn btn-success w-100 mt-5">Simpan</button>
    </form>
</div>
@endsection

@section('custom_script')
<script>

</script>
@endsection