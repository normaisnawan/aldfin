@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Master Peruntukan</h5>
          <a href="{{ route('peruntukan.create') }}" class="btn btn-primary btn-sm">
            <i data-lucide="plus" class="w-4 h-4 me-2"></i> Tambah Peruntukan
          </a>
        </div>

        @if ($message = Session::get('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-custom mb-0 align-middle" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th width="50px">No</th>
                <th>Nama Peruntukan</th>
                <th>Deskripsi</th>
                <th width="150px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($peruntukans as $index => $peruntukan)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $peruntukan->nama }}</td>
                  <td>{{ $peruntukan->deskripsi ?? '-' }}</td>
                  <td>
                    <form action="{{ route('peruntukan.destroy', $peruntukan->id) }}" method="POST" class="d-flex gap-2">
                      <a class="btn btn-sm btn-info text-white" href="{{ route('peruntukan.edit', $peruntukan->id) }}">
                        <i data-lucide="edit" class="w-4 h-4"></i>
                      </a>
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-sm btn-danger btn-delete">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    lucide.createIcons();
  </script>
@endsection