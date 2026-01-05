@extends('layouts.app')
@section('content')
    <div class="content"> <!-- Stat Cards -->
        <div class="row g-1 mb-1">
            <!-- Card 1 -->
            <div class="col-12 col-sm-6 col-lg-6">
                <div class="custom-card p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-secondary fw-medium small mb-1">Saldo Kas</p>
                            <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3>
                            <p class="{{ $saldoKasChange >= 0 ? 'text-success-custom' : 'text-danger-custom' }} fw-semibold mt-2 mb-0"
                                style="font-size: 12px;">
                                @if($saldoKasChange >= 0)↑ @else↓ @endif{{ number_format(abs($saldoKasChange), 1) }}% <span
                                    class="text-secondary fw-normal">vs bulan lalu</span>
                            </p>
                        </div>
                        <div class="stat-icon-wrapper bg-primary-light text-primary-custom">
                            <i data-lucide="wallet" width="24"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-12 col-sm-6 col-lg-6">
                <div class="custom-card p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-secondary fw-medium small mb-1">Pendapatan (Bulan Ini)</p>
                            <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
                            <p class="{{ $pemasukanChange >= 0 ? 'text-success-custom' : 'text-danger-custom' }} fw-semibold mt-2 mb-0"
                                style="font-size: 12px;">
                                @if($pemasukanChange >= 0)↑ @else↓ @endif{{ number_format(abs($pemasukanChange), 1) }}%
                                <span class="text-secondary fw-normal">vs bulan lalu</span>
                            </p>
                        </div>
                        <div class="stat-icon-wrapper bg-success-light text-success-custom">
                            <i data-lucide="trending-up" width="24"></i>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row g-1 mb-2">
<!-- Card 3 -->
            <div class="col-12 col-sm-6 col-lg-6">
                <div class="custom-card p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-secondary fw-medium small mb-1">Pengeluaran (Bulan Ini)</p>
                            <h3 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                            <p class="{{ $pengeluaranChange <= 0 ? 'text-success-custom' : 'text-danger-custom' }} fw-semibold mt-2 mb-0"
                                style="font-size: 12px;">
                                @if($pengeluaranChange <= 0)↓ @else↑ @endif{{ number_format(abs($pengeluaranChange), 1) }}%
                                <span class="text-secondary fw-normal">vs bulan lalu</span>
                            </p>
                        </div>
                        <div class="stat-icon-wrapper bg-danger-light text-danger-custom">
                            <i data-lucide="trending-down" width="24"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="col-12 col-sm-6 col-lg-6">
                <div class="custom-card p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-secondary fw-medium small mb-1">Laba Bersih (Bulan Ini)</p>
                            <h3 class="fw-bold mb-0 {{ $labaBersih >= 0 ? 'text-success-custom' : 'text-danger-custom' }}">
                                Rp {{ number_format($labaBersih, 0, ',', '.') }}</h3>
                            <p class="{{ $labaBersihChange >= 0 ? 'text-success-custom' : 'text-danger-custom' }} fw-semibold mt-2 mb-0"
                                style="font-size: 12px;">
                                @if($labaBersihChange >= 0)↑ @else↓ @endif{{ number_format(abs($labaBersihChange), 1) }}%
                                <span class="text-secondary fw-normal">vs bulan lalu</span>
                            </p>
                        </div>
                        <div class="stat-icon-wrapper bg-warning-light text-warning-custom">
                            <i data-lucide="bar-chart-3" width="24"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row g-1 mb-2">
            <div class="col-12 col-lg-8">
                <div class="custom-card p-4">
                    <h5 class="fw-bold text-dark mb-4">Pendapatan vs Pengeluaran (6 Bulan Terakhir)</h5>
                    <div style="height: 300px; width: 100%;">
                        <canvas id="incomeChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="custom-card p-4">
                    <h5 class="fw-bold text-dark mb-4">Breakdown Pengeluaran (Bulan Ini)</h5>
                    <div style="height: 300px; width: 100%; display: flex; justify-content: center;">
                        <canvas id="expenseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Table -->
        <div class="custom-card overflow-hidden">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0">Transaksi Terbaru</h5>
                <a href="{{ route('laporan.pemasukan') }}"
                    class="btn btn-link text-primary-custom text-decoration-none fw-medium p-0">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0 align-middle text-nowrap">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Akun</th>
                            <th>Outlet</th>
                            <th>Keterangan</th>
                            <th class="text-end">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $transaction)
                            <tr class="hover-bg-light">
                                <td class="text-secondary">{{ $transaction->tanggal->format('d/m/Y') }}</td>
                                <td>
                                    @if($transaction->jenis == 'pemasukan')
                                        <span class="status-badge bg-success-light text-success-custom">Pemasukan</span>
                                    @else
                                        <span class="status-badge bg-danger-light text-danger-custom">Pengeluaran</span>
                                    @endif
                                </td>
                                <td class="fw-medium">{{ $transaction->akun->nama_akun ?? '-' }}</td>
                                <td class="text-secondary">{{ $transaction->outlet->nama ?? '-' }}</td>
                                <td class="text-secondary">{{ Str::limit($transaction->keterangan, 30) ?? '-' }}</td>
                                <td
                                    class="text-end fw-bold {{ $transaction->jenis == 'pemasukan' ? 'text-success-custom' : 'text-danger-custom' }}">
                                    {{ $transaction->jenis == 'pemasukan' ? '+' : '-' }}Rp
                                    {{ number_format($transaction->jumlah, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        // --- Charts Configuration (Chart.js) ---

        // Chart data from controller
        const chartLabels = @json($chartLabels);
        const chartPemasukan = @json($chartPemasukan).map(v => parseFloat(v) || 0);
        const chartPengeluaran = @json($chartPengeluaran).map(v => parseFloat(v) || 0);
        const expenseBreakdown = @json($expenseBreakdown);

        // Income Area Chart
        const ctxIncome = document.getElementById('incomeChart').getContext('2d');
        const gradientIncome = ctxIncome.createLinearGradient(0, 0, 0, 300);
        gradientIncome.addColorStop(0, 'rgba(40, 199, 111, 0.1)');
        gradientIncome.addColorStop(1, 'rgba(40, 199, 111, 0)');

        const gradientExpense = ctxIncome.createLinearGradient(0, 0, 0, 300);
        gradientExpense.addColorStop(0, 'rgba(234, 84, 85, 0.1)');
        gradientExpense.addColorStop(1, 'rgba(234, 84, 85, 0)');

        new Chart(ctxIncome, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Pendapatan',
                    data: chartPemasukan,
                    borderColor: '#28C76F',
                    backgroundColor: gradientIncome,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 6
                },
                {
                    label: 'Pengeluaran',
                    data: chartPengeluaran,
                    borderColor: '#EA5455',
                    backgroundColor: gradientExpense,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 6
                }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#2E2E3A',
                        bodyColor: '#5E6278',
                        borderColor: '#f0f0f0',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: true,
                        boxPadding: 4,
                        callbacks: {
                            label: function (context) {
                                return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#5E6278',
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        border: {
                            display: false
                        },
                        grid: {
                            color: '#f0f0f0',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            color: '#5E6278',
                            font: {
                                size: 11
                            },
                            callback: function (value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Expense Breakdown Pie Chart
        const ctxExpenseBreakdown = document.getElementById('expenseChart').getContext('2d');

        // Prepare data for pie chart
        const expenseLabels = expenseBreakdown.map(item => item.akun);
        const expenseData = expenseBreakdown.map(item => parseFloat(item.total) || 0);

        // Colors for pie chart
        const pieColors = ['#2B2D8F', '#28C76F', '#FF9F43', '#EA5455', '#7367F0', '#00CFE8', '#FF6E6E', '#9B8DF4'];

        new Chart(ctxExpenseBreakdown, {
            type: 'doughnut',
            data: {
                labels: expenseLabels.length > 0 ? expenseLabels : ['Tidak ada data'],
                datasets: [{
                    data: expenseData.length > 0 ? expenseData : [1],
                    backgroundColor: expenseData.length > 0 ? pieColors.slice(0, expenseLabels.length) : ['#e0e0e0'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                family: 'Inter'
                            },
                            color: '#5E6278'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection