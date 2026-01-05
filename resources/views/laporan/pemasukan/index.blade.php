@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    {{-- Summary Cards --}}
    <div class="row mb-4">
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted mb-1 small">Total Pemasukan</p>
                <h4 class="fw-bold text-success mb-0">Rp {{ number_format($summary['total'], 0, ',', '.') }}</h4>
              </div>
              <div class="bg-success bg-opacity-10 p-3 rounded">
                <i data-lucide="trending-up" class="text-success" width="24"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted mb-1 small">Jumlah Transaksi</p>
                <h4 class="fw-bold text-primary mb-0">{{ number_format($summary['count']) }}</h4>
              </div>
              <div class="bg-primary bg-opacity-10 p-3 rounded">
                <i data-lucide="file-text" class="text-primary" width="24"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted mb-1 small">Rata-rata</p>
                <h4 class="fw-bold text-info mb-0">Rp {{ number_format($summary['average'], 0, ',', '.') }}</h4>
              </div>
              <div class="bg-info bg-opacity-10 p-3 rounded">
                <i data-lucide="calculator" class="text-info" width="24"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted mb-1 small">Tertinggi</p>
                <h4 class="fw-bold text-warning mb-0">Rp {{ number_format($summary['max'], 0, ',', '.') }}</h4>
              </div>
              <div class="bg-warning bg-opacity-10 p-3 rounded">
                <i data-lucide="arrow-up-circle" class="text-warning" width="24"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Filter Card --}}
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-white">
        <h6 class="mb-0"><i data-lucide="filter" class="w-4 h-4 me-2"></i> Filter Laporan</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('laporan.pemasukan') }}" method="GET">
          <div class="row g-3">
            <div class="col-md-2">
              <label class="form-label small">Tanggal Mulai</label>
              <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
            </div>
            <div class="col-md-2">
              <label class="form-label small">Tanggal Akhir</label>
              <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
            </div>
            <div class="col-md-2">
              <label class="form-label small">Akun</label>
              <select class="form-select" name="akun_id">
                <option value="">Semua Akun</option>
                @foreach ($akuns as $akun)
                  <option value="{{ $akun->id }}" {{ $akunId == $akun->id ? 'selected' : '' }}>
                    {{ $akun->nama_akun }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label small">Outlet</label>
              <select class="form-select" name="outlet_id">
                <option value="">Semua Outlet</option>
                @foreach ($outlets as $outlet)
                  <option value="{{ $outlet->id }}" {{ $outletId == $outlet->id ? 'selected' : '' }}>
                    {{ $outlet->nama }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label small">No. Transaksi</label>
              <input type="text" class="form-control" name="nomor_transaksi" value="{{ $nomorTransaksi }}"
                placeholder="TRIN-...">
            </div>
            <div class="col-md-2">
              <label class="form-label small">&nbsp;</label>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                  <i data-lucide="search" class="w-4 h-4"></i>
                </button>
                <a href="{{ route('laporan.pemasukan') }}" class="btn btn-secondary">
                  <i data-lucide="x" class="w-4 h-4"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="row g-3 mt-1">
            <div class="col-md-2">
              <label class="form-label small">Peruntukan</label>
              <select class="form-select" name="peruntukan_id">
                <option value="">Semua Peruntukan</option>
                @foreach ($peruntukans as $peruntukan)
                  <option value="{{ $peruntukan->id }}" {{ $peruntukanId == $peruntukan->id ? 'selected' : '' }}>
                    {{ $peruntukan->nama }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label small">Nominal Min</label>
              <input type="number" class="form-control" name="min_amount" value="{{ $minAmount }}" placeholder="0">
            </div>
            <div class="col-md-2">
              <label class="form-label small">Nominal Max</label>
              <input type="number" class="form-control" name="max_amount" value="{{ $maxAmount }}" placeholder="0">
            </div>
          </div>
        </form>
      </div>
    </div>

    {{-- Charts Row --}}
    <div class="row mb-4">
      <div class="col-lg-8 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-header bg-white">
            <h6 class="mb-0"><i data-lucide="bar-chart-2" class="w-4 h-4 me-2"></i> Trend Pemasukan per Tanggal</h6>
          </div>
          <div class="card-body">
            <canvas id="chartByDate" height="120"></canvas>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-header bg-white">
            <h6 class="mb-0"><i data-lucide="pie-chart" class="w-4 h-4 me-2"></i> Distribusi per Akun</h6>
          </div>
          <div class="card-body">
            <canvas id="chartByAkun" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>

    {{-- Data Table --}}
    <div class="card shadow-sm">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i data-lucide="table" class="w-4 h-4 me-2"></i> Detail Transaksi</h6>
        <div class="d-flex gap-2">
          <a href="{{ route('laporan.pemasukan.excel', request()->query()) }}" class="btn btn-sm btn-success">
            <i data-lucide="file-spreadsheet" class="w-4 h-4 me-1"></i> Excel
          </a>
          <a href="{{ route('laporan.pemasukan.print', request()->query()) }}" class="btn btn-sm btn-secondary"
            target="_blank">
            <i data-lucide="printer" class="w-4 h-4 me-1"></i> Print
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle" id="dataTable">
            <thead class="table-light">
              <tr>
                <th>No. Transaksi</th>
                <th>Tanggal</th>
                <th>Akun</th>
                <th>Outlet</th>
                <th class="text-end">Jumlah</th>
                <th>Peruntukan</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($pemasukans as $pemasukan)
                <tr>
                  <td><code>{{ $pemasukan->nomor_transaksi }}</code></td>
                  <td>{{ $pemasukan->tanggal->format('d/m/Y') }}</td>
                  <td>
                    <span class="badge bg-success">{{ $pemasukan->akun->kode_akun }}</span>
                    {{ $pemasukan->akun->nama_akun }}
                  </td>
                  <td>{{ $pemasukan->outlet->nama }}</td>
                  <td class="text-end fw-bold text-success">Rp {{ number_format($pemasukan->jumlah, 0, ',', '.') }}</td>
                  <td>{{ $pemasukan->peruntukan->nama ?? '-' }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">Tidak ada data pemasukan</td>
                </tr>
              @endforelse
            </tbody>
            <tfoot class="table-light">
              <tr>
                <th colspan="4" class="text-end">Total:</th>
                <th class="text-end text-success">Rp {{ number_format($summary['total'], 0, ',', '.') }}</th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    lucide.createIcons();

    // Chart by Date
    const chartByDateCtx = document.getElementById('chartByDate').getContext('2d');
    new Chart(chartByDateCtx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($chartByDate->keys()) !!},
        datasets: [{
          label: 'Pemasukan',
          data: {!! json_encode($chartByDate->values()) !!},
          backgroundColor: 'rgba(40, 167, 69, 0.7)',
          borderColor: 'rgba(40, 167, 69, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function (value) {
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });

    // Chart by Akun
    const chartByAkunCtx = document.getElementById('chartByAkun').getContext('2d');
    new Chart(chartByAkunCtx, {
      type: 'doughnut',
      data: {
        labels: {!! json_encode($chartByAkun->pluck('nama')) !!},
        datasets: [{
          data: {!! json_encode($chartByAkun->pluck('total')) !!},
          backgroundColor: [
            'rgba(40, 167, 69, 0.8)',
            'rgba(23, 162, 184, 0.8)',
            'rgba(255, 193, 7, 0.8)',
            'rgba(0, 123, 255, 0.8)',
            'rgba(111, 66, 193, 0.8)',
            'rgba(253, 126, 20, 0.8)',
          ]
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });
  </script>
@endsection