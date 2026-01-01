@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Rencana Produksi</h5>
          <div class="d-flex gap-2">
            <a href="{{ route('rencana-produksi.export.pdf') }}" class="btn btn-danger btn-sm">
              <i data-lucide="file-text" class="w-4 h-4 me-2"></i> Export PDF
            </a>
            <a href="{{ route('rencana-produksi.export.excel') }}" class="btn btn-success btn-sm">
              <i data-lucide="file-spreadsheet" class="w-4 h-4 me-2"></i> Export Excel
            </a>
            <a href="{{ route('rencana-produksi.create') }}" class="btn btn-primary btn-sm">
              <i data-lucide="plus" class="w-4 h-4 me-2"></i> Buat Rencana Baru
            </a>
          </div>
        </div>
        @if ($message = Session::get('success'))
          <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
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
                <th>ID Rencana</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Menu</th>
                <th class="text-center">Porsi</th>
                <th>Status</th>
                <th width="150px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($plans as $plan)
                <tr>
                  <td><span
                      class="badge bg-secondary font-monospace">{{ $plan->nomor_rencana ?? 'RP-' . str_pad($plan->id, 6, '0', STR_PAD_LEFT) }}</span>
                  </td>
                  <td>{{ $plan->tanggal }}</td>
                  <td class="fw-bold text-dark">{{ $plan->customer->nama }}</td>
                  <td>{{ $plan->formula->nama }}</td>
                  <td class="text-center">{{ $plan->porsi }}</td>
                  <td><span class="badge bg-success">{{ $plan->status }}</span></td>
                  <td>
                    <form action="{{ route('rencana-produksi.destroy', $plan->id) }}" method="POST" class="d-flex gap-2">
                      <a class="btn btn-sm btn-danger text-white"
                        href="{{ route('rencana-produksi.detail.export.pdf', $plan->id) }}" title="Export PDF">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                      </a>
                      <a class="btn btn-sm btn-success text-white"
                        href="{{ route('rencana-produksi.detail.export.excel', $plan->id) }}" title="Export Excel">
                        <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                      </a>
                      <a class="btn btn-sm btn-info text-white" href="{{ route('rencana-produksi.edit', $plan->id) }}">
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