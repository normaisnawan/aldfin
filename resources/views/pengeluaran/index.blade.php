@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <div class="card shadow mb-4">
      <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <h5>Daftar Pengeluaran</h5>
          <a href="{{ route('pengeluaran.create') }}" class="btn btn-primary btn-sm">
            <i data-lucide="plus" class="w-4 h-4 me-2"></i> Tambah Pengeluaran
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
                <th>No Transaksi</th>
                <th>Tanggal</th>
                <th>Akun</th>
                <th>Outlet</th>
                <th class="text-end">Jumlah</th>
                <th>Status</th>
                <th>Peruntukan</th>
                <th width="220px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pengeluarans as $pengeluaran)
                <tr>
                  <td><code>{{ $pengeluaran->nomor_transaksi }}</code></td>
                  <td>{{ $pengeluaran->tanggal->format('d/m/Y') }}</td>
                  <td>
                    <span class="badge bg-warning text-dark">{{ $pengeluaran->akun->kode_akun }}</span>
                    {{ $pengeluaran->akun->nama_akun }}
                  </td>
                  <td>{{ $pengeluaran->outlet->nama }}</td>
                  <td class="text-end fw-bold text-danger">Rp {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</td>
                  <td>
                    @if ($pengeluaran->status === 'unpaid')
                      <span class="badge bg-warning text-dark">Unpaid</span>
                    @else
                      <span class="badge bg-success">Paid</span>
                    @endif
                  </td>
                  <td>{{ $pengeluaran->peruntukan->nama ?? '-' }}</td>
                  <td>
                    <div class="d-flex gap-1 flex-wrap">
                      {{-- Lampiran Button --}}
                      @if ($pengeluaran->lampiran)
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-view-lampiran"
                          data-lampiran="{{ asset('storage/' . $pengeluaran->lampiran) }}"
                          data-nomor="{{ $pengeluaran->nomor_transaksi }}"
                          data-type="{{ pathinfo($pengeluaran->lampiran, PATHINFO_EXTENSION) }}" title="Lihat Lampiran">
                          <i data-lucide="paperclip" class="w-4 h-4"></i>
                        </button>
                        @if ($pengeluaran->isUnpaid())
                          <form action="{{ route('pengeluaran.delete-lampiran', $pengeluaran->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-lampiran" title="Hapus Lampiran">
                              <i data-lucide="file-x" class="w-4 h-4"></i>
                            </button>
                          </form>
                        @endif
                      @endif

                      {{-- Payment Button - Only for unpaid --}}
                      @if ($pengeluaran->isUnpaid())
                        <a class="btn btn-sm btn-success text-white"
                          href="{{ route('pengeluaran.payment', $pengeluaran->id) }}" title="Payment">
                          <i data-lucide="credit-card" class="w-4 h-4"></i>
                        </a>
                      @endif

                      {{-- Print Button - Always visible --}}
                      <a class="btn btn-sm btn-secondary text-white"
                        href="{{ route('pengeluaran.print', $pengeluaran->id) }}" target="_blank" title="Print">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                      </a>

                      {{-- Edit Button - Only for unpaid --}}
                      @if ($pengeluaran->isUnpaid())
                        <a class="btn btn-sm btn-info text-white" href="{{ route('pengeluaran.edit', $pengeluaran->id) }}"
                          title="Edit">
                          <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                      @endif

                      {{-- Delete Button - Only for unpaid --}}
                      @if ($pengeluaran->isUnpaid())
                        <form action="{{ route('pengeluaran.destroy', $pengeluaran->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-sm btn-danger btn-delete" title="Delete">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                          </button>
                        </form>
                      @endif

                      {{-- Show Button - Only for paid (read-only) --}}
                      @if ($pengeluaran->isPaid())
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('pengeluaran.show', $pengeluaran->id) }}"
                          title="Detail">
                          <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                      @endif
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

  <!-- Modal Lampiran -->
  <div class="modal fade" id="modalLampiran" tabindex="-1" aria-labelledby="modalLampiranLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLampiranLabel">Lampiran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center" id="lampiranContent">
          <!-- Content will be loaded here -->
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-primary" id="btnDownloadLampiran" target="_blank">
            <i data-lucide="download" class="w-4 h-4 me-2"></i> Download
          </a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    lucide.createIcons();

    $(document).ready(function () {
      // View Lampiran
      $('.btn-view-lampiran').on('click', function () {
        const lampiran = $(this).data('lampiran');
        const nomor = $(this).data('nomor');
        const type = $(this).data('type').toLowerCase();
        const imageTypes = ['jpg', 'jpeg', 'png', 'gif'];

        $('#modalLampiranLabel').text('Lampiran - ' + nomor);
        $('#btnDownloadLampiran').attr('href', lampiran);

        if (imageTypes.includes(type)) {
          $('#lampiranContent').html('<img src="' + lampiran + '" class="img-fluid rounded" alt="Lampiran">');
        } else {
          $('#lampiranContent').html(
            '<div class="py-5">' +
            '<i data-lucide="file-text" style="width: 64px; height: 64px;" class="text-muted mb-3"></i>' +
            '<p class="text-muted mb-0">File dokumen tidak dapat ditampilkan preview.</p>' +
            '<p class="text-muted">Klik tombol Download untuk mengunduh file.</p>' +
            '</div>'
          );
          lucide.createIcons();
        }

        $('#modalLampiran').modal('show');
      });

      // Delete Lampiran
      $('.btn-delete-lampiran').on('click', function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        Swal.fire({
          title: 'Hapus Lampiran?',
          text: "Lampiran yang dihapus tidak dapat dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  </script>
@endsection