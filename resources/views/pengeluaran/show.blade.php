@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Detail Pengeluaran</h5>
          <a href="{{ route('pengeluaran.index') }}" class="btn btn-light btn-sm">
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
                <td><code class="fs-5">{{ $pengeluaran->nomor_transaksi }}</code></td>
              </tr>
              <tr>
                <td class="text-muted" width="180">Tanggal</td>
                <td><strong>{{ $pengeluaran->tanggal->format('d/m/Y') }}</strong></td>
              </tr>
              <tr>
                <td class="text-muted">Akun Pengeluaran</td>
                <td>
                  <span class="badge bg-warning text-dark">{{ $pengeluaran->akun->kode_akun }}</span>
                  {{ $pengeluaran->akun->nama_akun }}
                </td>
              </tr>
              <tr>
                <td class="text-muted">Outlet</td>
                <td>{{ $pengeluaran->outlet->nama }}</td>
              </tr>
              <tr>
                <td class="text-muted">Jumlah</td>
                <td><strong class="text-danger fs-4">Rp {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</strong>
                </td>
              </tr>
              <tr>
                <td class="text-muted">Peruntukan</td>
                <td>{{ $pengeluaran->peruntukan->nama ?? '-' }}</td>
              </tr>
              <tr>
                <td class="text-muted">Keterangan</td>
                <td>{{ $pengeluaran->keterangan ?? '-' }}</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-borderless">
              <tr>
                <td class="text-muted" width="180">Status</td>
                <td>
                  @if ($pengeluaran->status === 'unpaid')
                    <span class="badge bg-warning text-dark fs-6">Unpaid</span>
                  @else
                    <span class="badge bg-success fs-6">Paid</span>
                  @endif
                </td>
              </tr>
              @if ($pengeluaran->isPaid())
                <tr>
                  <td class="text-muted">Tanggal Bayar</td>
                  <td><strong>{{ $pengeluaran->paid_at->format('d/m/Y H:i') }}</strong></td>
                </tr>
                <tr>
                  <td class="text-muted">ID Transaksi</td>
                  <td>
                    @if ($pengeluaran->transaksiKeuangan)
                      <span class="badge bg-info">#{{ $pengeluaran->transaksi_keuangan_id }}</span>
                    @else
                      -
                    @endif
                  </td>
                </tr>
              @endif
              <tr>
                <td class="text-muted">Dibuat</td>
                <td>{{ $pengeluaran->created_at->format('d/m/Y H:i') }}</td>
              </tr>
              <tr>
                <td class="text-muted">Diupdate</td>
                <td>{{ $pengeluaran->updated_at->format('d/m/Y H:i') }}</td>
              </tr>
            </table>
          </div>
        </div>

        @if ($pengeluaran->isPaid())
          <div class="alert alert-success">
            <i data-lucide="check-circle" class="w-4 h-4 me-2"></i>
            <strong>Sudah Dibayar:</strong> Pengeluaran ini telah dicatat ke transaksi keuangan dan bersifat read-only.
          </div>
        @endif

        <div class="d-flex justify-content-end gap-2">
          <a href="{{ route('pengeluaran.print', $pengeluaran->id) }}" class="btn btn-secondary" target="_blank">
            <i data-lucide="printer" class="w-4 h-4 me-2"></i> Print
          </a>
          @if ($pengeluaran->isUnpaid())
            <a href="{{ route('pengeluaran.payment', $pengeluaran->id) }}" class="btn btn-success">
              <i data-lucide="credit-card" class="w-4 h-4 me-2"></i> Payment
            </a>
          @endif
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