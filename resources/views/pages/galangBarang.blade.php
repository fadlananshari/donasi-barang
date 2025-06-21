@extends('layouts.pages')

@section('title', 'Galang Barang')

{{-- @section('custom_body_class', 'bg-secondary') --}}

@section('active-menu-home', 'active text-primary')

@section('content')
<div class="container mt-4">
    <p>Isi formulir untuk menggalang bantuan berikut</p>
    <form class="container mb-5 my-2 p-4 border rounded shadow bg-white">      
        <!-- Nama Sesuai KTP -->
        <div class="mb-3">
          <label for="namaKtp" class="form-label">Nama Sesuai KTP</label>
          <input type="text" class="form-control" id="namaKtp" name="nama_ktp" required>
        </div>
      
        <!-- Nomor HP -->
        <div class="mb-3">
          <label for="noHp" class="form-label">Nomor HP</label>
          <input type="tel" class="form-control" id="noHp" name="no_hp" required>
        </div>
      
        <!-- Pekerjaan Saat Ini -->
        <div class="mb-3">
          <label for="pekerjaan" class="form-label">Pekerjaan Saat Ini</label>
          <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
        </div>
      
        <!-- Nama Penerima Manfaat -->
        <div class="mb-3">
          <label for="penerimaManfaat" class="form-label">Nama Penerima Manfaat</label>
          <input type="text" class="form-control" id="penerimaManfaat" name="penerima_manfaat" required>
        </div>
      
        <!-- Tombol Tambah Barang -->
        <div class="mb-3 d-flex justify-content-end">
            <button type="button" class="btn btn-success" onclick="tambahBarang()">Tambah Barang</button>
        </div>          
      
        <!-- Barang yang Dibutuhkan -->
        <div id="barangContainer">
          <div class="mb-3 row">
            <div class="col">
              <label class="form-label">Nama Barang</label>
              <input type="text" class="form-control" name="barang[]" required>
            </div>
            <div class="col">
              <label class="form-label">Jumlah</label>
              <input type="number" class="form-control" name="jumlah_barang[]" required>
            </div>
          </div>
        </div>
      
        <!-- Judul Galang Barang -->
        <div class="mb-3">
          <label for="judulGalang" class="form-label">Judul Galang Barang</label>
          <input type="text" class="form-control" id="judulGalang" name="judul" required>
        </div>
      
        <!-- Upload Foto Cover -->
        <div class="mb-3">
            <label for="fotoCover" class="form-label">Upload Foto untuk Cover Halaman</label>
            <input class="form-control" type="file" id="fotoCover" name="foto_cover" accept="image/*" onchange="previewFoto(event)">
            <img id="previewImage" class="mt-3 rounded" style="max-width: 100%; height: auto; display: none;" alt="Preview">
        </div> 
      
        <!-- Cerita -->
        <div class="mb-3">
          <label for="cerita" class="form-label">Cerita</label>
          <textarea class="form-control" id="cerita" name="cerita" rows="5" placeholder="Tuliskan latar belakang kenapa galang barang ini penting..." required></textarea>
        </div>
      
        <!-- Submit Button -->
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
    </form>    
</div>
@endsection

@section('custom_script')
<script>
    
    function tambahBarang() {
        const container = document.getElementById('barangContainer');

        const div = document.createElement('div');
        div.classList.add('row', 'mb-3', 'align-items-end');

        div.innerHTML = `
            <div class="col-6">
                <label class="form-label">Nama Barang</label>
                <input type="text" class="form-control" name="barang[]" required>
            </div>
            <div class="col-3">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" name="jumlah_barang[]" required>
            </div>
            <div class="col">
                <label class="form-label d-block">Hapus</label>
                <button type="button" class="btn btn-danger" onclick="hapusBarang(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        
        container.appendChild(div);
    }  

    function hapusBarang(button) {
        const row = button.closest('.row');
        if (row) {
        row.remove();
        }
    }

    function previewFoto(event) {
        const input = event.target;
        const preview = document.getElementById('previewImage');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }


</script>
@endsection