@extends('layouts.penerima')

@section('title', 'Proposal')

@section('active-menu-proposal', 'active text-success')

@section('content')
<div class="container my-4">

    <h4 class="fw-semibold text-success">Tambah proposal donasi</h4>

    <div class="accordion my-4" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button 
              class="accordion-button collapsed text-success fw-semibold" 
              type="button" 
              data-bs-toggle="collapse" 
              data-bs-target="#collapseOne" 
              aria-expanded="false" 
              aria-controls="collapseOne"
              aria-label="Panduan Pengisian Form Proposal Donasi"
            >
              📌 Panduan Pengisian Form Proposal Donasi
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
                  <strong>Judul Proposal</strong>
                  <p>Buat judul yang menggambarkan kebutuhan donasi secara jelas dan menarik. Contoh: <em>“Bantuan Pangan untuk Korban Banjir Jakarta”</em>.</p>
                </li>
      
                <li class="list-group-item">
                  <strong>Gambar Proposal</strong>
                  <p>
                    Unggah gambar yang akan menjadi tampilan utama campaign (misalnya kondisi bencana atau penerima manfaat).
                  </p>
                </li>

                <li class="list-group-item">
                  <strong>Gambar Surat Pendukung</strong>
                  <p>
                    Unggah gambar surat permohonan resmi sebagai bukti validitas proposal.
                  </p>
                </li>
      
                <li class="list-group-item">
                  <strong>Nomor Surat</strong>
                  <p>Isi dengan nomor dari surat resmi, contohnya: <em>001/BANJIR-JKT/2025</em>.</p>
                </li>
      
                <li class="list-group-item">
                  <strong>Jenis Donasi</strong>
                  <p>Pilih jenis donasi yang diajukan.</p>
                </li>
      
                <li class="list-group-item">
                  <strong>Cerita Singkat</strong>
                  <p>
                    Ceritakan secara ringkas latar belakang dan alasan Anda mengajukan donasi. Cerita ini akan ditampilkan ke donatur untuk meningkatkan empati.
                  </p>
                </li>
      
                <li class="list-group-item">
                  <strong>Alamat Penerima</strong>
                  <p>Masukkan alamat lengkap tempat barang donasi akan diterima atau didistribusikan.</p>
                </li>
      
                <li class="list-group-item">
                  <strong>Daftar Barang yang Diajukan</strong>
                  <ul class="mt-1">
                    <li><strong>Nama Barang:</strong> Pilih jenis barang yang telah tersedia di sistem (misal: Beras, Alat Tulis, obat).</li>
                    <li><strong>Detail Barang (Opsional):</strong> Tulis tambahan informasi jika diperlukan seperti ukuran, merk, jenis obat, dll.</li>
                    <li><strong>Jumlah:</strong> Masukkan jumlah barang yang dibutuhkan (misal: 10 buah, 20 paket, dll).</li>
                  </ul>
                </li>
      
              </ol>
      
              <div class="alert alert-info mt-3" role="alert">
                Pastikan semua data telah diisi dengan lengkap dan benar. Proposal yang jelas dan informatif akan lebih cepat diproses dan dipercaya oleh donatur.
              </div>
            </div>
          </div>
        </div>
      </div>
      
      
    
    <form action="{{ route('penerima.storeProposal') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-white">
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
            <label for="title" class="form-label fw-semibold">Judul Proposal</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" aria-required="true" required>
        </div>
    
        {{-- Gambar Proposal --}}
        <div class="mb-3">
            <label for="image_campaign" class="form-label fw-semibold">Gambar Proposal</label>
            <input type="file" class="form-control" id="image_campaign" name="image_campaign" accept="image/*" onchange="previewImageCampaign(event)" aria-required="true" required>
            <div class="my-3">
                <img id="imageCampaignPreview" src="#" alt="Preview Gambar" class="img-thumbnail" style="display: none; max-height: 200px;">
            </div>
        </div>
    
        {{-- Gambar Surat --}}
        <div class="mb-3">
            <label for="image_letter" class="form-label fw-semibold">Gambar Surat Pendukung</label>
            <input type="file" class="form-control" id="image_letter" name="image_letter" accept="image/*" onchange="previewImageLetter(event)" aria-required="true" required>
            <div class="my-3">
                <img id="imageLetterPreview" src="#" alt="Preview Gambar" class="img-thumbnail" style="display: none; max-height: 200px;">
            </div>
        </div>
    
        {{-- Nomor Surat --}}
        <div class="mb-3">
            <label for="letter_number" class="form-label fw-semibold">Nomor Surat</label>
            <input type="text" class="form-control" id="letter_number" name="letter_number" value="{{ old('letter_number') }}" aria-required="true" required>
        </div>
    
        {{-- Jenis Donasi --}}
        <div class="mb-3">
            <label for="id_donation_type" class="form-label fw-semibold">Jenis Donasi</label>
            <select id="id_donation_type" name="id_donation_type" class="form-control" aria-required="true" required>
                <option value="" disabled selected>-- Pilih Jenis Donasi --</option>
                @foreach ($donationTypes as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        
        {{-- Cerita --}}
        <div class="mb-3">
            <label for="story" class="form-label fw-semibold">Cerita Singkat</label>
            <textarea class="form-control" id="story" name="story" rows="4" aria-required="true" required>{{ old('story') }}</textarea>
        </div>
    
        {{-- Alamat --}}
        <div class="mb-3">
            <label for="address" class="form-label fw-semibold">Alamat Penerima</label>
            <textarea class="form-control" id="address" name="address" rows="3" aria-required="true" required>{{ old('address') }}</textarea>
        </div>
    
        {{-- Daftar Barang --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Daftar Barang yang Diajukan</label><br>
            <a href="{{route('penerima.tambahItemType')}}" class="text-decoration-none d-inline-block py-2 px-1" style="min-height: 44px;" role="button">
              Jenis barang yang ingin diajukan tidak ada? Klik disini
            </a>
            
            <div id="itemsContainer" class="mt-2">
                <div class="item-group border p-3 mb-3 rounded bg-light">
                    <div class="mb-2">
                        <label>Nama Barang</label>
                        <select name="items[0][name]" class="form-control" aria-required="true" required>
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
                        <input type="text" name="items[0][quantity]" class="form-control" aria-required="true" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-outline-success btn-sm" onclick="addItem()">+ Tambah Barang</button>
        </div>
    
        <button type="submit" class="btn btn-success w-100">Simpan Proposal</button>
    </form>
    
</div>
@endsection

@section('custom_script')
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
                    <select name="items[${itemIndex}][name]" class="form-control" aria-required="true" required>
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
                    <input type="text" name="items[${itemIndex}][quantity]" class="form-control" aria-required="true" required>
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