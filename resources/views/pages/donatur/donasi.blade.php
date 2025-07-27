@extends('layouts.donatur')

@section('title', 'Donasi')
@section('active-menu-donate', 'active text-success')

@section('custom_css')
.accordion-button:not(.collapsed) {
    background-color: #d1e7dd; /* background hijau muda */
    color: #0f5132; /* teks hijau gelap */
  }
  
@endsection

@section('content')
<div class="container mt-3">
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

        <div class="mx-lg-5">
            <img src="{{ asset('storage/' . $proposal->image_campaign) }}" alt="" class="img-fluid w-100">
        </div>
        
        <input type="hidden" name="id_profile" value="{{ $profile->id }}">
        <input type="hidden" name="id_donation_proposal" value="{{ $proposal->id }}">

        <h1 class="fs-1 fw-bold text-center">{{ $proposal->title }}</h1>

        <div class="mt-5">
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

        {{-- Tata Cara Berdonasi --}}
        <div class="accordion mb-4" id="accordionExample">
            <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button 
                class="accordion-button collapsed text-success fw-semibold" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#collapseOne" 
                aria-expanded="false" 
                aria-controls="collapseOne"
                >
                📝 Tata Cara Mengirim Donasi Barang
                </button>
            </h2>
        
            <div 
                id="collapseOne" 
                class="accordion-collapse collapse" 
                aria-labelledby="headingOne" 
                data-bs-parent="#accordionExample"
            >
                <div class="accordion-body">
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">
                    <strong>Bungkus barang yang ingin didonasikan</strong>
                    <p>Pastikan barang dalam kondisi baik dan dibungkus dengan aman untuk mencegah kerusakan saat pengiriman.</p>
                    </li>
        
                    <li class="list-group-item">
                        <strong>Kirim barang ke alamat berikut:</strong>
                        <div class="d-flex align-items-start justify-content-between mt-1">
                            <p id="alamat-donasi" class="mb-0">{{ $proposal->user->name }}, {{ $proposal->address }}</p>
                          <button onclick="copyAlamat()" class="btn btn-sm btn-outline-success ms-2">Salin</button>
                        </div>
                    </li>

                    <li class="list-group-item">
                        <strong>Gunakan jasa ekspedisi yang tersedia</strong>
                        <p class="m-0">Berikut jasa ekspedisi yang tersedia:</p>
                        <ul class="mt-1">
                          @foreach ($deliveryServices as $item)
                            <li>{{ $item->name }}</li>
                          @endforeach
                        </ul>
                    </li>
                      
        
                    <li class="list-group-item">
                    <strong>Isi Formulir Donasi di Website</strong>
                    <ul class="mt-1">
                        <li>Masukkan <strong>daftar barang yang didonasikan</strong></li>
                        <li>Pilih <strong>jenis ekspedisi</strong> yang digunakan</li>
                        <li>Masukkan <strong>nomor resi</strong> pengiriman sebagai bukti</li>
                    </ul>
                    </li>
                </ol>
                <div class="alert alert-warning mt-3" role="alert">
                    Pastikan anda telah membayar ongkirnya.
                </div>
                </div>
            </div>
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
    function copyAlamat() {
      const alamat = document.getElementById('alamat-donasi').textContent;
      navigator.clipboard.writeText(alamat).then(function () {
        alert('Alamat berhasil disalin!');
      }, function (err) {
        alert('Gagal menyalin alamat.');
      });
    }
</script>
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
                                    {{ $item->name }}
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
