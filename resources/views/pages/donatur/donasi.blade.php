@extends('layouts.donatur')

@section('title', 'Donasi')
@section('active-menu-donate', 'active text-success')

@section('content')
<div class="container mt-4">
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

    <form action="{{ route('donatur.donasiStore') }}" method="POST" class="mb-5">
        @csrf

        <img src="{{ asset('storage/' . $proposal->image_campaign) }}" alt="" class="img-fluid mb-3">
        
        <input type="hidden" name="id_profile" value="{{ Auth::user()->id }}">
        <input type="hidden" name="id_donation_proposal" value="{{ $proposal->id }}">

        <div class="form-group">
            <label class="fw-semibold">Judul Proposal</label>
            <p>{{ $proposal->title }}</p>
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

        {{-- Barang Donasi --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Daftar Barang yang Didonasikan</label>
            <div id="itemsContainer">
                <div class="item-group border p-3 mb-3 rounded bg-light">
                    <div class="mb-2">
                        <label>Nama Barang</label>
                        <select name="items[0][name]" class="form-control" required onchange="updateMax(this, 0)">
                            <option value="">-- Pilih Barang Yang ingin Didonasikan --</option>
                            @foreach($proposalItemsUpdated as $item)
                                @if ($item->remaining_quantity > 0)
                                    <option value="{{ $item->name }}" data-remaining="{{ $item->remaining_quantity }}">
                                        {{ $item->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Jumlah</label>
                        <input type="number" name="items[0][quantity]" id="quantity-0" class="form-control" min="1" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-outline-success btn-sm" onclick="addItem()">+ Tambah Barang</button>
        </div>

        <div class="form-group mb-3">
            <label for="id_delivery_service" class="fw-semibold">Ekspedisi</label>
            <select name="id_delivery_service" id="id_delivery_service" class="form-control" required>
                <option value="">-- Pilih Ekspedisi --</option>
                @foreach($deliveryServices as $deliveryService)
                    <option value="{{ $deliveryService->id }}">{{ $deliveryService->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="tracking_number" class="fw-semibold">Nomor Resi</label>
            <input type="text" name="tracking_number" id="tracking_number" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Simpan</button>
    </form>
</div>
@endsection

@section('custom_script')
<script>
    let itemIndex = 1;

    function addItem() {
        const container = document.getElementById('itemsContainer');
        const html = `
            <div class="item-group border p-3 mb-3 rounded bg-light position-relative">
                <button type="button" class="btn btn-sm btn-danger btn-remove position-absolute" style="top: 10px; right: 10px;" onclick="removeItem(this)">X</button>
                <div class="mb-2">
                    <label>Nama Barang</label>
                    <select name="items[${itemIndex}][name]" class="form-control" required onchange="updateMax(this, ${itemIndex})">
                        <option value="">-- Pilih Barang Yang ingin Didonasikan --</option>
                        @foreach($proposalItemsUpdated as $item)
                            @if ($item->remaining_quantity > 0)
                                <option value="{{ $item->name }}" data-remaining="{{ $item->remaining_quantity }}">
                                    {{ $item->name . ' (' . $item->detail . ')' }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Jumlah</label>
                    <input type="number" name="items[${itemIndex}][quantity]" id="quantity-${itemIndex}" class="form-control" min="1" required>
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

    function updateMax(selectEl, index) {
        const selectedOption = selectEl.options[selectEl.selectedIndex];
        const remaining = selectedOption.getAttribute('data-remaining');
        const quantityInput = document.getElementById(`quantity-${index}`);
        if (remaining) {
            quantityInput.max = remaining;
        } else {
            quantityInput.removeAttribute('max');
        }
    }
</script>
@endsection
