@extends('layouts.admin')

@section('title', 'Edit Proposal Donasi')

@section('active-menu-donation-proposals', 'active')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Proposal Donasi</h1>
</div>

<form action="{{ route('admin.updateProposal', $proposal->id) }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-white">
    @csrf
    @method('POST')

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

    <input type="hidden" name="id_profile" value="{{ $proposal->id_profile }}">

    {{-- Judul --}}
    <div class="mb-3">
        <label for="title" class="form-label">Judul Proposal</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $proposal->title) }}" required>
    </div>

    {{-- Gambar Proposal --}}
    <div class="mb-3">
        <label for="image_campaign" class="form-label">Gambar Proposal</label>
        <input type="file" class="form-control" id="image_campaign" name="image_campaign" accept="image/*" onchange="previewImageCampaign(event)">
        <div class="my-3">
            <img id="imageCampaignPreview" src="{{ asset('storage/' . $proposal->image_campaign) }}" alt="Preview Gambar" class="img-thumbnail" style="max-height: 200px;">
        </div>
    </div>

    {{-- Gambar Surat --}}
    <div class="mb-3">
        <label for="image_letter" class="form-label">Gambar Surat Pendukung</label>
        <input type="file" class="form-control" id="image_letter" name="image_letter" accept="image/*" onchange="previewImageLetter(event)">
        <div class="my-3">
            <img id="imageLetterPreview" src="{{ asset('storage/' . $proposal->image_letter) }}" alt="Preview Gambar" class="img-thumbnail" style="max-height: 200px;">
        </div>
    </div>

    {{-- Nomor Surat --}}
    <div class="mb-3">
        <label for="letter_number" class="form-label">Nomor Surat</label>
        <input type="text" class="form-control" id="letter_number" name="letter_number" value="{{ old('letter_number', $proposal->letter_number) }}" required>
    </div>

    {{-- Jenis Donasi --}}
    <div class="mb-3">
        <label for="id_donation_type" class="form-label">Jenis Donasi</label>
        <select name="id_donation_type" id="id_donation_type" class="form-control" required>
            <option value="" disabled>-- Pilih Jenis Donasi --</option>
            @foreach ($donationTypes as $item)
                <option value="{{ $item->id }}" {{ old('id_donation_type', $proposal->id_donation_type) == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Cerita --}}
    <div class="mb-3">
        <label for="story" class="form-label">Cerita Singkat</label>
        <textarea class="form-control" id="story" name="story" rows="4" required>{{ old('story', $proposal->story) }}</textarea>
    </div>

    {{-- Alamat --}}
    <div class="mb-3">
        <label for="address" class="form-label">Alamat Penerima</label>
        <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', $proposal->address) }}</textarea>
    </div>

    {{-- Status --}}
    <div class="mb-4">
        <label for="status" class="form-label">Status Proposal</label>
        <select name="status" id="status" class="form-control" required>
            <option value="1" {{ old('status', $proposal->status) == 1 ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('status', $proposal->status) == 0 ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </div>

    {{-- Daftar Barang --}}
    <div class="mb-4">
        <label class="form-label">Daftar Barang yang Diajukan</label>
        <div id="itemsContainer">
            @foreach ($proposal->proposalItems as $index => $item)
                <div class="item-group border p-3 mb-3 rounded bg-light position-relative">
                    <button type="button" class="btn btn-sm btn-danger" style="position: absolute; top: 8px; right: 8px;" onclick="removeItem(this)">X</button>
                    <div class="mb-2">
                        <label>Nama Barang</label>
                        <select name="items[{{ $index }}][name]" class="form-control" required>
                            <option value="" disabled>-- Pilih Jenis Barang --</option>
                            @foreach ($itemTypes as $itemType)
                                <option value="{{ $itemType->name }}" {{ old("items.$index.name", $item->name) == $itemType->name ? 'selected' : '' }}>
                                    {{ $itemType->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Detail Barang (Opsional)</label>
                        <input type="text" name="items[{{ $index }}][detail]" class="form-control" value="{{ old("items.$index.detail", $item->detail) }}">
                    </div>
                    <div>
                        <label>Jumlah</label>
                        <input type="text" name="items[{{ $index }}][quantity]" class="form-control" value="{{ old("items.$index.quantity", $item->quantity) }}" required>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addItem()">+ Tambah Barang</button>
    </div>

    <button type="submit" class="btn btn-primary w-100">Update Proposal</button>
</form>

@endsection

@section('custom_js')
<script>
    function previewImageCampaign(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('imageCampaignPreview');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function previewImageLetter(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('imageLetterPreview');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    let itemIndex = {{ count($proposal->proposalItems) }};
    function addItem() {
        const container = document.getElementById('itemsContainer');
        const itemOptions = @json($itemTypes).map(item => `<option value="${item.name}">${item.name}</option>`).join('');
        const html = `
            <div class="item-group border p-3 mb-3 rounded bg-light position-relative">
                <button type="button" class="btn btn-sm btn-danger" style="position: absolute; top: 8px; right: 8px;" onclick="removeItem(this)">X</button>
                <div class="mb-2">
                    <label>Nama Barang</label>
                    <select name="items[${itemIndex}][name]" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Jenis Barang --</option>
                        ${itemOptions}
                    </select>
                </div>
                <div class="mb-2">
                    <label>Detail Barang (Opsional)</label>
                    <input type="text" name="items[${itemIndex}][detail]" class="form-control">
                </div>
                <div>
                    <label>Jumlah</label>
                    <input type="text" name="items[${itemIndex}][quantity]" class="form-control" required>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        itemIndex++;
    }

    function removeItem(button) {
        const itemGroup = button.closest('.item-group');
        itemGroup.remove();
    }
</script>
@endsection
