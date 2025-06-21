@extends('layouts.admin')

@section('title', 'Tambah Proposal Donasi')

@section('active-menu-donation-proposals', 'active')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Proposal Donasi</h1>
</div>

<form action="{{ route('admin.storeProposal') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-white">
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

    <input type="hidden" name="id_profile" value="{{ Auth::user()->id }}">

    {{-- Judul --}}
    <div class="mb-3">
        <label for="title" class="form-label">Judul Proposal</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
    </div>

    {{-- Gambar Proposal --}}
    <div class="mb-3">
        <label for="image_campaign" class="form-label">Gambar Proposal</label>
        <input type="file" class="form-control" id="image_campaign" name="image_campaign" accept="image/*" onchange="previewImageCampaign(event)" required>
        <div class="my-3">
            <img id="imageCampaignPreview" src="#" alt="Preview Gambar" class="img-thumbnail" style="display: none; max-height: 200px;">
        </div>
    </div>

    {{-- Gambar Surat --}}
    <div class="mb-3">
        <label for="image_letter" class="form-label">Gambar Surat Pendukung</label>
        <input type="file" class="form-control" id="image_letter" name="image_letter" accept="image/*" onchange="previewImageLetter(event)" required>
        <div class="my-3">
            <img id="imageLetterPreview" src="#" alt="Preview Gambar" class="img-thumbnail" style="display: none; max-height: 200px;">
        </div>
    </div>

    {{-- Nomor Surat --}}
    <div class="mb-3">
        <label for="letter_number" class="form-label">Nomor Surat</label>
        <input type="text" class="form-control" id="letter_number" name="letter_number" value="{{ old('letter_number') }}" required>
    </div>

    {{-- Jenis Donasi --}}
    <div class="mb-3">
        <label for="id_donation_type" class="form-label">Jenis Donasi</label>
        <select name="id_donation_type" id="id_donation_type" class="form-control" required>
            <option value="" disabled selected>-- Pilih Jenis Donasi --</option>
            @foreach ($donationTypes as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Cerita --}}
    <div class="mb-3">
        <label for="story" class="form-label">Cerita Singkat</label>
        <textarea class="form-control" id="story" name="story" rows="4" required>{{ old('story') }}</textarea>
    </div>

    {{-- Alamat --}}
    <div class="mb-3">
        <label for="address" class="form-label">Alamat Penerima</label>
        <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
    </div>

    {{-- Status --}}
    <div class="mb-4">
        <label for="status" class="form-label">Status Proposal</label>
        <select name="status" id="status" class="form-control" required>
            <option value="1">Aktif</option>
            <option value="0">Nonaktif</option>
        </select>
    </div>

    {{-- Daftar Barang --}}
    <div class="mb-4">
        <label class="form-label">Daftar Barang yang Diajukan</label>
        <div id="itemsContainer">
            <div class="item-group border p-3 mb-3 rounded bg-light">
                <div class="mb-2">
                    <label>Nama Barang</label>
                    <select name="items[0][name]" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Jenis Barang --</option>
                        @foreach ($itemTypes as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Detail barang (Opsional)</label>
                    <input type="text" name="items[0][detail]" class="form-control">
                </div>
                <div>
                    <label>Jumlah</label>
                    <input type="text" name="items[0][quantity]" class="form-control" required>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addItem()">+ Tambah Barang</button>
    </div>

    <button type="submit" class="btn btn-primary w-100">Simpan Proposal</button>
</form>

@endsection

@section('custom_js')
<script>
    function previewImageCampaign(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imageCampaignPreview').src = e.target.result;
            document.getElementById('imageCampaignPreview').style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function previewImageLetter(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imageLetterPreview').src = e.target.result;
            document.getElementById('imageLetterPreview').style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    let itemIndex = 1;
    function addItem() {
        const container = document.getElementById('itemsContainer');
        const html = `
            <div class="item-group border p-3 mb-3 rounded bg-light position-relative">
                <button type="button" 
                        class="btn btn-sm btn-danger" 
                        style="position: absolute; top: 8px; right: 8px;" 
                        aria-label="Close" 
                        onclick="removeItem(this)">X</button>
                <div class="mb-2">
                    <label>Nama Barang</label>
                    <select name="items[${itemIndex}][name]" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Jenis Barang --</option>
                        ${@json($itemTypes).map(item => `<option value="${item.name}">${item.name}</option>`).join('')}
                    </select>
                </div>
                <div class="mb-2">
                    <label>Detail barang (Opsional)</label>
                    <input type="text" name="items[${itemIndex}][detail]" class="form-control">
                </div>
                <div>
                    <label>Jumlah</label>
                    <input type="text" name="items[${itemIndex}][quantity]" class="form-control" required>
                </div>
            </div>`;


        container.insertAdjacentHTML('beforeend', html);
        itemIndex++;
    }

    function removeItem(button) {
        const itemGroup = button.closest('.item-group');
        itemGroup.remove();
    }

</script>
@endsection
