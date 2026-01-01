@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Tambah Akun Baru</h2>
            <a href="{{ route('akun.index') }}" class="btn btn-light btn-sm">
              <i data-lucide="arrow-left" class="w-4 h-4 me-2"></i> Kembali
            </a>
        </div>
      </div>
      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('akun.store') }}" method="POST">
          @csrf
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="kode_akun" class="form-label">Kode Akun</label>
              <input type="text" class="form-control" id="kode_akun" name="kode_akun" value="{{ old('kode_akun') }}"
                placeholder="Contoh: 1101" required>
            </div>
            <div class="col-md-6">
              <label for="nama_akun" class="form-label">Nama Akun</label>
              <input type="text" class="form-control" id="nama_akun" name="nama_akun" value="{{ old('nama_akun') }}"
                placeholder="Contoh: Kas Besar" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="tipe_akun" class="form-label">Tipe Akun</label>
            <select class="form-select" id="tipe_akun" name="tipe_akun" required>
              <option value="">Pilih Tipe Akun</option>
              <option value="Pemasukan" {{ old('tipe_akun') == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
              <option value="Pengeluaran" {{ old('tipe_akun') == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
              placeholder="Contoh: Akun untuk mencatat kas besar">{{ old('deskripsi') }}</textarea>
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
              <i data-lucide="save" class="w-4 h-4 me-2"></i> Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    lucide.createIcons();
  </script>
@endsection