@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Tambah Customer Baru</h5>
          <a href="{{ route('customers.index') }}" class="btn btn-light btn-sm">
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

        <form action="{{ route('customers.store') }}" method="POST">
          @csrf
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="nama" class="form-label">Nama Customer</label>
              <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}"
                placeholder="Contoh: PT. Maju Jaya" required>
            </div>
            <div class="col-md-6">
              <label for="no_hp" class="form-label">No HP</label>
              <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                placeholder="Contoh: 081234567890">
            </div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
              placeholder="Contoh: email@example.com">
          </div>

          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3"
              placeholder="Contoh: Jl. Jend. Sudirman No. 1">{{ old('alamat') }}</textarea>
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