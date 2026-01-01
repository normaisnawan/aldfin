@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Edit Bahan</h5>
          <a href="{{ route('bahan.index') }}" class="btn btn-light btn-sm">
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

        <form action="{{ route('bahan.update', $bahan->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Bahan</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $bahan->nama) }}"
              placeholder="Contoh: Tepung Terigu, Gula Pasir" required>
          </div>
          <div class="mb-3">
            <label for="satuan_id" class="form-label">Satuan</label>
            <select class="form-select" id="satuan_id" name="satuan_id" required>
              <option value="">-- Pilih Satuan --</option>
              @foreach ($satuans as $satuan)
                <option value="{{ $satuan->id }}" {{ old('satuan_id', $bahan->satuan_id) == $satuan->id ? 'selected' : '' }}>
                  {{ $satuan->nama }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
              <i data-lucide="save" class="w-4 h-4 me-2"></i> Update
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