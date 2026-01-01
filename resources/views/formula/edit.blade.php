@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Edit Formula</h5>
          <a href="{{ route('formula.index') }}" class="btn btn-light btn-sm">
            <i data-lucide="arrow-left" class="w-4 h-4 me-2"></i> Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        @if ($message = Session::get('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('formula.update', $formula->id) }}" method="POST" class="mb-4">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Menu</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $formula->nama) }}"
              placeholder="Contoh: Nasi Goreng Spesial" required>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2"
              placeholder="Contoh: Nasi goreng dengan telur dan ayam suwir">{{ old('deskripsi', $formula->deskripsi) }}</textarea>
          </div>

          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
              <i data-lucide="save" class="w-4 h-4 me-2"></i> Update Info Formula
            </button>
          </div>
        </form>

        <hr>
        <h6 class="mb-3">Komponen Bahan</h6>

        <!-- Add Ingredient Form -->
        <div class="card bg-light mb-3">
          <div class="card-body">
            <form action="{{ route('formula.item.store', $formula->id) }}" method="POST" class="row g-3 align-items-end">
              @csrf
              <div class="col-md-5">
                <label for="bahan_id" class="form-label">Bahan Baku</label>
                <select class="form-select" name="bahan_id" id="bahan_id" required>
                  <option value="">Pilih Bahan</option>
                  @foreach ($bahans as $bahan)
                    <option value="{{ $bahan->id }}">{{ $bahan->nama }} ({{ $bahan->satuan->nama }})</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label for="qty" class="form-label">Qty</label>
                <input type="number" step="0.01" class="form-control" name="qty" id="qty" placeholder="Qty" required>
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100">
                  <i data-lucide="plus" class="w-4 h-4 me-2"></i> Tambah
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Ingredients List -->
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Bahan Baku</th>
              <th width="200px">Qty</th>
              <th width="100px">Satuan</th>
              <th width="50px"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($formula->items as $item)
              <tr>
                <td>{{ $item->bahan->nama }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->bahan->satuan->nama }}</td>
                <td>
                  <form action="{{ route('formula.item.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
                      <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center text-muted">Belum ada bahan yang ditambahkan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    lucide.createIcons();
  </script>
@endsection