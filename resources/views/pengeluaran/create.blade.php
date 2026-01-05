@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Tambah Pengeluaran Baru</h5>
          <a href="{{ route('pengeluaran.index') }}" class="btn btn-light btn-sm">
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

        <form action="{{ route('pengeluaran.store') }}" method="POST">
          @csrf
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="tanggal" class="form-label">Tanggal</label>
              <input type="date" class="form-control" id="tanggal" name="tanggal"
                value="{{ old('tanggal', date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6">
              <label for="jumlah" class="form-label">Jumlah (Rp)</label>
              <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah') }}"
                placeholder="0" step="1" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="akun_id" class="form-label">Akun Pengeluaran</label>
              <select class="form-select" id="akun_id" name="akun_id" required>
                <option value="">Pilih Akun Pengeluaran</option>
                @foreach ($akuns as $akun)
                  <option value="{{ $akun->id }}" {{ old('akun_id') == $akun->id ? 'selected' : '' }}>
                    {{ $akun->kode_akun }} - {{ $akun->nama_akun }}
                  </option>
                @endforeach
              </select>
              @if ($akuns->isEmpty())
                <small class="text-muted">Belum ada akun dengan tipe "Pengeluaran". Silakan tambahkan di Master
                  Akun.</small>
              @endif
            </div>
            <div class="col-md-6">
              <label for="outlet_id" class="form-label">Outlet</label>
              <select class="form-select" id="outlet_id" name="outlet_id" required>
                <option value="">Pilih Outlet</option>
                @foreach ($outlets as $outlet)
                  <option value="{{ $outlet->id }}" {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>
                    {{ $outlet->nama }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="peruntukan_id" class="form-label">Peruntukan</label>
              <select class="form-select" id="peruntukan_id" name="peruntukan_id">
                <option value="">Pilih Peruntukan (Opsional)</option>
                @foreach ($peruntukans as $peruntukan)
                  <option value="{{ $peruntukan->id }}" {{ old('peruntukan_id') == $peruntukan->id ? 'selected' : '' }}>
                    {{ $peruntukan->nama }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
              placeholder="Keterangan pengeluaran...">{{ old('keterangan') }}</textarea>
          </div>

          <div class="alert alert-info">
            <i data-lucide="info" class="w-4 h-4 me-2"></i>
            <strong>Info:</strong> Pengeluaran akan disimpan dengan status <strong>Unpaid</strong>.
            Lakukan proses Payment untuk mencatat ke transaksi keuangan.
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