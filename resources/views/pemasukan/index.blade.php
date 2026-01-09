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
                <th width="180px">Aksi</th>
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
                      {{-- Lampiran Button --}}
                      @if ($pemasukan->lampiran)
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-view-lampiran"
                          data-lampiran="{{ asset('storage/' . $pemasukan->lampiran) }}"
                          data-nomor="{{ $pemasukan->nomor_transaksi }}"
                          data-type="{{ pathinfo($pemasukan->lampiran, PATHINFO_EXTENSION) }}" title="Lihat Lampiran">
                          <i data-lucide="paperclip" class="w-4 h-4"></i>
                        </button>
                        <form action="{{ route('pemasukan.delete-lampiran', $pemasukan->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-sm btn-outline-danger btn-delete-lampiran" title="Hapus Lampiran">
                            <i data-lucide="file-x" class="w-4 h-4"></i>
                          </button>
                        </form>
                      @endif

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