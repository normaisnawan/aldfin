@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Detail Pemasukan</h5>
          <a href="{{ route('pemasukan.index') }}" class="btn btn-light btn-sm">
            <i data-lucide="arrow-left" class="w-4 h-4 me-2"></i> Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-borderless">
              <tr>
                <td class="text-muted" width="180">No. Transaksi</td>
                <td><code class="fs-5">{{ $pemasukan->nomor_transaksi }}</code></td>
              </tr>
              <tr>
                <td class="text-muted" width="180">Tanggal</td>
                <td><strong>{{ $pemasukan->tanggal->format('d/m/Y') }}</strong></td>
              </tr>
              <tr>
                <td class="text-muted">Akun Pemasukan</td>
                <td>
                  <span class="badge bg-success">{{ $pemasukan->akun->kode_akun }}</span>
                  {{ $pemasukan->akun->nama_akun }}
                </td>
              </tr>
              <tr>
                <td class="text-muted">Outlet</td>
                <td>{{ $pemasukan->outlet->nama }}</td>
              </tr>
              <tr>
                <td class="text-muted">Jumlah</td>
                <td><strong class="text-success fs-4">Rp {{ number_format($pemasukan->jumlah, 0, ',', '.') }}</strong>
                </td>
              </tr>
              <tr>
                <td class="text-muted">Peruntukan</td>
                <td>{{ $pemasukan->peruntukan->nama ?? '-' }}</td>
              </tr>
              <tr>
                <td class="text-muted">Keterangan</td>
                <td>{{ $pemasukan->keterangan ?? '-' }}</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-borderless">
              <tr>
                <td class="text-muted" width="180">Status</td>
                <td>
                  <span class="badge bg-success fs-6">Paid</span>
                </td>
              </tr>
              <tr>
                <td class="text-muted">Tanggal Tercatat</td>
                <td><strong>{{ $pemasukan->paid_at ? $pemasukan->paid_at->format('d/m/Y H:i') : '-' }}</strong></td>
              </tr>
              <tr>
                <td class="text-muted">ID Transaksi Keuangan</td>
                <td>
                  @if ($pemasukan->transaksiKeuangan)
                    <span class="badge bg-info">#{{ $pemasukan->transaksi_keuangan_id }}</span>
                  @else
                    -
                  @endif
                </td>
              </tr>
              <tr>
                <td class="text-muted">Dibuat</td>
                <td>{{ $pemasukan->created_at->format('d/m/Y H:i') }}</td>
              </tr>
              <tr>
                <td class="text-muted">Diupdate</td>
                <td>{{ $pemasukan->updated_at->format('d/m/Y H:i') }}</td>
              </tr>
            </table>
          </div>
        </div>

        <div class="alert alert-success">
          <i data-lucide="check-circle" class="w-4 h-4 me-2"></i>
          <strong>Tercatat:</strong> Pemasukan ini telah dicatat ke transaksi keuangan dan bersifat final.
        </div>

        <div class="d-flex justify-content-end gap-2">
          <a href="{{ route('pemasukan.print', $pemasukan->id) }}" class="btn btn-secondary" target="_blank">
            <i data-lucide="printer" class="w-4 h-4 me-2"></i> Print
          </a>
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