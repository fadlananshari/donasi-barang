@extends('layouts.admin')

@section('title', 'Tambah Barang Donasi')

@section('custom_css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .item-group .btn-remove {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
@endsection

@section('active-menu-donation-items', 'active')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Barang Donasi</h1>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.storeDonationItem') }}" method="POST">
                @csrf
                
                <input type="text" name="id_profile" id="id_profile" value="{{ Auth::user()->id }}" hidden>

                <div class="form-group">
                    <label for="id_donation_proposal">Judul Proposal</label>
                    <p class="">{{ $proposal->title }}</p>
                    <input type="text" name="id_donation_proposal" id="id_donation_proposal" value="{{ $proposal->id }}" hidden>
                </div>

                {{-- Barang Donasi --}}
                <div class="mb-4">
                    <label class="form-label">Daftar Barang yang Didonasikan</label>
                    <div id="itemsContainer">
                        <div class="item-group border p-3 mb-3 rounded bg-light">
                            <div class="mb-2">
                                <label>Nama Barang</label>
                                <select name="items[0][name]" class="form-control" required>
                                    <option value="">-- Pilih Barang Yang ingin Didonasikan --</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label>Jumlah</label>
                                <input type="number" name="items[0][quantity]" class="form-control" min="1" required>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addItem()">+ Tambah Barang</button>
                </div>

                <div class="form-group">
                    <label for="id_delivery_service">Ekspedisi</label>
                    <select name="id_delivery_service" id="id_delivery_service" class="form-control" required>
                        <option value="">-- Pilih Ekspedisi --</option>
                        @foreach($deliveryServices as $deliveryService)
                            <option value="{{ $deliveryService->id }}">{{ $deliveryService->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tracking_number">Nomor Resi</label>
                    <input type="text" name="tracking_number" id="tracking_number" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@section('custom_js')
<script>
    let itemIndex = 1;
    function addItem() {
        const container = document.getElementById('itemsContainer');
        const html = `
            <div class="item-group border p-3 mb-3 rounded bg-light position-relative">
                <button type="button"
                        class="btn btn-sm btn-danger btn-remove"
                        aria-label="Close"
                        onclick="removeItem(this)">X</button>

                <div class="mb-2">
                    <label>Nama Barang</label>
                    <select name="items[${itemIndex}][name]" class="form-control" required>
                        <option value="">-- Pilih Barang Yang ingin Didonasikan --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Jumlah</label>
                    <input type="number" name="items[${itemIndex}][quantity]" class="form-control" min="1" required>
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
