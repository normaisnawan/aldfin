@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Konfirmasi Pembayaran</h5>
          <a href="{{ route('pengeluaran.index') }}" class="btn btn-light btn-sm">
            <i data-lucide="arrow-left" class="w-4 h-4 me-2"></i> Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="alert alert-warning">
          <i data-lucide="alert-triangle" class="w-4 h-4 me-2"></i>
          <strong>Perhatian:</strong> Setelah pembayaran diproses, data pengeluaran tidak dapat diedit atau dihapus.
        </div>

        <div class="card bg-light mb-4">
          <div class="card-body">
            <h6 class="card-title mb-3">Detail Pengeluaran</h6>
            <div class="row">
              <div class="col-md-6">
                <table class="table table-borderless mb-0">
                  <tr>
                    <td class="text-muted" width="150">No. Transaksi</td>
                    <td><code>{{ $pengeluaran->nomor_transaksi }}</code></td>
                  </tr>
                  <tr>
                    <td class="text-muted" width="150">Tanggal</td>
                    <td><strong>{{ $pengeluaran->tanggal->format('d/m/Y') }}</strong></td>
                  </tr>
                  <tr>
                    <td class="text-muted">Akun</td>
                    <td>
                      <span class="badge bg-warning text-dark">{{ $pengeluaran->akun->kode_akun }}</span>
                      {{ $pengeluaran->akun->nama_akun }}
                    </td>
                  </tr>
                  <tr>
                    <td class="text-muted">Outlet</td>
                    <td>{{ $pengeluaran->outlet->nama }}</td>
                  </tr>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-borderless mb-0">
                  <tr>
                    <td class="text-muted" width="150">Jumlah</td>
                    <td><strong class="text-danger fs-4">Rp
                        {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</strong></td>
                  </tr>
                  <tr>
                    <td class="text-muted">Status</td>
                    <td><span class="badge bg-warning text-dark">Unpaid</span></td>
                  </tr>
                  <tr>
                    <td class="text-muted">Keterangan</td>
                    <td>{{ $pengeluaran->keterangan ?? '-' }}</td>
                  </tr>
                  @if ($pengeluaran->lampiran)
                    <tr>
                      <td class="text-muted">Lampiran</td>
                      <td>
                        <a href="{{ asset('storage/' . $pengeluaran->lampiran) }}" target="_blank"
                          class="btn btn-sm btn-outline-primary">
                          <i data-lucide="paperclip" class="w-4 h-4 me-1"></i> Lihat Lampiran
                        </a>
                      </td>
                    </tr>
                  @endif
                </table>
              </div>
            </div>
          </div>
        </div>

        <form action="{{ route('pengeluaran.process-payment', $pengeluaran->id) }}" method="POST" id="paymentForm">
          @csrf
          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">
              <i data-lucide="x" class="w-4 h-4 me-2"></i> Batal
            </a>
            <button type="button" class="btn btn-success" id="btnConfirmPayment">
              <i data-lucide="check-circle" class="w-4 h-4 me-2"></i> Bayar Sekarang
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

    document.getElementById('btnConfirmPayment').addEventListener('click', function (e) {
      e.preventDefault();

      Swal.fire({
        title: 'Konfirmasi Pembayaran',
        html: '<p>Apakah Anda yakin ingin memproses pembayaran ini?</p><p><strong>Jumlah: <span class="text-danger">Rp {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</span></strong></p>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Proses Pembayaran',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          // Show loading
          const btn = document.getElementById('btnConfirmPayment');
          btn.disabled = true;
          btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';

          Swal.fire({
            title: 'Memproses Pembayaran',
            text: 'Mohon tunggu...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          document.getElementById('paymentForm').submit();
        }
      });
    });
  </script>
@endsection