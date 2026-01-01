@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Edit Outlet</h5>
          <a href="{{ route('outlets.index') }}" class="btn btn-light btn-sm">
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

        <form action="{{ route('outlets.update', $outlet->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="nama" class="form-label">Nama Outlet</label>
              <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $outlet->nama) }}"
                placeholder="Contoh: Cabang Jakarta" required>
            </div>
            <div class="col-md-6">
              <label for="telepon" class="form-label">Telepon</label>
              <input type="text" class="form-control" id="telepon" name="telepon"
                value="{{ old('telepon', $outlet->telepon) }}" placeholder="Contoh: 081234567890">
            </div>
          </div>

          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3"
              placeholder="Contoh: Jl. Sudirman No. 1">{{ old('alamat', $outlet->alamat) }}</textarea>
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