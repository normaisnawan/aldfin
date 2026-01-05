@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Daftar Pemasukan</h5>
          <a href="{{ route('pemasukan.create') }}" class="btn btn-primary btn-sm">
            <i data-lucide="plus" class="w-4 h-4 me-2"></i> Tambah Pemasukan
          </a>
        </div>

        @if ($message = Session::get('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if ($message = Session::get('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                <th>No. Transaksi</th>
                <th>Tanggal</th>
                <th>Akun</th>
                <th>Outlet</th>
                <th class="text-end">Jumlah</th>
                <th>Status</th>
                <th>Peruntukan</th>
                <th width="150px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pemasukans as $pemasukan)
                <tr>
                  <td><code>{{ $pemasukan->nomor_transaksi }}</code></td>
                  <td>{{ $pemasukan->tanggal->format('d/m/Y') }}</td>
                  <td>
                    <span class="badge bg-success">{{ $pemasukan->akun->kode_akun }}</span>
                    {{ $pemasukan->akun->nama_akun }}
                  </td>
                  <td>{{ $pemasukan->outlet->nama }}</td>
                  <td class="text-end fw-bold text-success">Rp {{ number_format($pemasukan->jumlah, 0, ',', '.') }}</td>
                  <td>
                    <span class="badge bg-success">Paid</span>
                  </td>
                  <td>{{ $pemasukan->peruntukan->nama ?? '-' }}</td>
                  <td>
                    <div class="d-flex gap-1 flex-wrap">
                      {{-- Print Button --}}
                      <a class="btn btn-sm btn-secondary text-white" href="{{ route('pemasukan.print', $pemasukan->id) }}"
                        target="_blank" title="Print">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                      </a>

                      {{-- Detail Button --}}
                      <a class="btn btn-sm btn-outline-primary" href="{{ route('pemasukan.show', $pemasukan->id) }}"
                        title="Detail">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                      </a>
                    </div>
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