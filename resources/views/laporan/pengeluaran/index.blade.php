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
                <p class="text-muted mb-1 small">Total Pengeluaran</p>
                <h4 class="fw-bold text-danger mb-0">Rp {{ number_format($summary['total'], 0, ',', '.') }}</h4>
              </div>
              <div class="bg-danger bg-opacity-10 p-3 rounded">
                <i data-lucide="trending-down" class="text-danger" width="24"></i>
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
                <p class="text-muted mb-1 small">Sudah Dibayar (Paid)</p>
                <h4 class="fw-bold text-success mb-0">Rp {{ number_format($summary['total_paid'], 0, ',', '.') }}</h4>
                <small class="text-muted">{{ $summary['count_paid'] }} transaksi</small>
              </div>
              <div class="bg-success bg-opacity-10 p-3 rounded">
                <i data-lucide="check-circle" class="text-success" width="24"></i>
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
                <p class="text-muted mb-1 small">Belum Dibayar (Unpaid)</p>
                <h4 class="fw-bold text-warning mb-0">Rp {{ number_format($summary['total_unpaid'], 0, ',', '.') }}</h4>
                <small class="text-muted">{{ $summary['count_unpaid'] }} transaksi</small>
              </div>
              <div class="bg-warning bg-opacity-10 p-3 rounded">
                <i data-lucide="clock" class="text-warning" width="24"></i>
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
                <small class="text-muted">{{ $summary['count'] }} transaksi</small>
              </div>
              <div class="bg-info bg-opacity-10 p-3 rounded">
                <i data-lucide="calculator" class="text-info" width="24"></i>
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
        <form action="{{ route('laporan.pengeluaran') }}" method="GET">
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
              <label class="form-label small">Status</label>
              <select class="form-select" name="status">
                <option value="">Semua Status</option>
                <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="unpaid" {{ $status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label small">&nbsp;</label>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                  <i data-lucide="search" class="w-4 h-4"></i>
                </button>
                <a href="{{ route('laporan.pengeluaran') }}" class="btn btn-secondary">
                  <i data-lucide="x" class="w-4 h-4"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="row g-3 mt-1">
            <div class="col-md-2">
              <label class="form-label small">No. Transaksi</label>
              <input type="text" class="form-control" name="nomor_transaksi" value="{{ $nomorTransaksi }}"
                placeholder="TROUT-...">
            </div>
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
            <h6 class="mb-0"><i data-lucide="bar-chart-2" class="w-4 h-4 me-2"></i> Trend Pengeluaran per Tanggal</h6>
          </div>
          <div class="card-body">
            <canvas id="chartByDate" height="150"></canvas>
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
      <!-- <div class="col-lg-3 mb-3">
                  <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                      <h6 class="mb-0"><i data-lucide="activity" class="w-4 h-4 me-2"></i> Status Pembayaran</h6>
                    </div>
                    <div class="card-body">
                      <canvas id="chartByStatus" height="200"></canvas>
                    </div>
                  </div>
                </div> -->
    </div>

    <div class="row mb-4">

    </div>

    {{-- Data Table --}}
    <div class="card shadow-sm">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i data-lucide="table" class="w-4 h-4 me-2"></i> Detail Transaksi</h6>
        <div class="d-flex gap-2">
          <a href="{{ route('laporan.pengeluaran.excel', request()->query()) }}" class="btn btn-sm btn-success">
            <i data-lucide="file-spreadsheet" class="w-4 h-4 me-1"></i> Excel
          </a>
          <a href="{{ route('laporan.pengeluaran.print', request()->query()) }}" class="btn btn-sm btn-secondary"
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
                <th>Status</th>
                <th>Peruntukan</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($pengeluarans as $pengeluaran)
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
                    @if ($pengeluaran->status === 'paid')
                      <span class="badge bg-success">Paid</span>
                    @else
                      <span class="badge bg-warning text-dark">Unpaid</span>
                    @endif
                  </td>
                  <td>{{ $pengeluaran->peruntukan->nama ?? '-' }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">Tidak ada data pengeluaran</td>
                </tr>
              @endforelse
            </tbody>
            <tfoot class="table-light">
              <tr>
                <th colspan="4" class="text-end">Total:</th>
                <th class="text-end text-danger">Rp {{ number_format($summary['total'], 0, ',', '.') }}</th>
                <th colspan="2"></th>
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
          label: 'Pengeluaran',
          data: {!! json_encode($chartByDate->values()) !!},
          backgroundColor: 'rgba(220, 53, 69, 0.7)',
          borderColor: 'rgba(220, 53, 69, 1)',
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
            'rgba(220, 53, 69, 0.8)',
            'rgba(255, 193, 7, 0.8)',
            'rgba(23, 162, 184, 0.8)',
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
            position: 'bottom',
            labels: {
              boxWidth: 12
            }
          }
        }
      }
    });

    // Chart by Status
    const chartByStatusCtx = document.getElementById('chartByStatus').getContext('2d');
    new Chart(chartByStatusCtx, {
      type: 'pie',
      data: {
        labels: ['Paid', 'Unpaid'],
        datasets: [{
          data: [{{ $summary['total_paid'] }}, {{ $summary['total_unpaid'] }}],
          backgroundColor: [
            'rgba(40, 167, 69, 0.8)',
            'rgba(255, 193, 7, 0.8)',
          ]
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'right'
          }
        }
      }
    });
  </script>
@endsection