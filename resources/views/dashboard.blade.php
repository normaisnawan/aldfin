@extends('layouts.app')
@section('content')
<div class="content"> <!-- Stat Cards -->
    <div class="row g-4 mb-5">
        <!-- Card 1 -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="custom-card p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-secondary fw-medium small mb-1">Saldo Kas</p>
                        <h3 class="fw-bold mb-0 text-dark">$24,500.00</h3>
                        <p class="text-success-custom fw-semibold mt-2 mb-0" style="font-size: 12px;">
                            ↑ 12% <span class="text-secondary fw-normal">vs last month</span>
                        </p>
                    </div>
                    <div class="stat-icon-wrapper bg-primary-light text-primary-custom">
                        <i data-lucide="wallet" width="24"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="custom-card p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-secondary fw-medium small mb-1">Pendapatan</p>
                        <h3 class="fw-bold mb-0 text-dark">$12,240.00</h3>
                        <p class="text-success-custom fw-semibold mt-2 mb-0" style="font-size: 12px;">
                            ↑ 8.2% <span class="text-secondary fw-normal">vs last month</span>
                        </p>
                    </div>
                    <div class="stat-icon-wrapper bg-success-light text-success-custom">
                        <i data-lucide="dollar-sign" width="24"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="custom-card p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-secondary fw-medium small mb-1">Pengeluaran</p>
                        <h3 class="fw-bold mb-0 text-dark">$4,320.50</h3>
                        <p class="text-secondary fw-semibold mt-2 mb-0" style="font-size: 12px;">
                            <span class="text-secondary fw-normal">On track</span>
                        </p>
                    </div>
                    <div class="stat-icon-wrapper bg-danger-light text-danger-custom">
                        <i data-lucide="trending-down" width="24"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 4 -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="custom-card p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-secondary fw-medium small mb-1">Laba Bersih</p>
                        <h3 class="fw-bold mb-0 text-dark">$7,919.50</h3>
                        <p class="text-warning-custom fw-semibold mt-2 mb-0" style="font-size: 12px;">
                            ↑ 5.4% <span class="text-secondary fw-normal">vs last month</span>
                        </p>
                    </div>
                    <div class="stat-icon-wrapper bg-warning-light text-warning-custom">
                        <i data-lucide="trending-up" width="24"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-lg-8">
            <div class="custom-card p-4">
                <h5 class="fw-bold text-dark mb-4">Income vs Expenses</h5>
                <div style="height: 300px; width: 100%;">
                    <canvas id="incomeChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="custom-card p-4">
                <h5 class="fw-bold text-dark mb-4">Expense Breakdown</h5>
                <div style="height: 300px; width: 100%; display: flex; justify-content: center;">
                    <canvas id="expenseChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="custom-card overflow-hidden">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0">Recent Transactions</h5>
            <button class="btn btn-link text-primary-custom text-decoration-none fw-medium p-0">View All</button>
        </div>
        <div class="table-responsive">
            <table class="table table-custom mb-0 align-middle text-nowrap">
                <thead>
                    <tr>
                        <th>Reference ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Entity</th>
                        <th class="text-end">Amount</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover-bg-light">
                        <td class="text-primary-custom fw-medium">TRX-9871</td>
                        <td class="text-secondary">2023-10-24</td>
                        <td class="fw-medium">Monthly Server Cost</td>
                        <td class="text-secondary">AWS Services</td>
                        <td class="text-end fw-bold text-dark">$450.00</td>
                        <td class="text-center"><span
                                class="status-badge bg-success-light text-success-custom">Lunas</span></td>
                    </tr>
                    <tr class="hover-bg-light">
                        <td class="text-primary-custom fw-medium">TRX-9872</td>
                        <td class="text-secondary">2023-10-24</td>
                        <td class="fw-medium">Client Payment</td>
                        <td class="text-secondary">TechCorp Ltd</td>
                        <td class="text-end fw-bold text-success-custom">+$2450.00</td>
                        <td class="text-center"><span class="status-badge bg-primary-light text-primary">Cleared</span>
                        </td>
                    </tr>
                    <tr class="hover-bg-light">
                        <td class="text-primary-custom fw-medium">TRX-9873</td>
                        <td class="text-secondary">2023-10-23</td>
                        <td class="fw-medium">Office Supplies</td>
                        <td class="text-secondary">Staples Inc</td>
                        <td class="text-end fw-bold text-dark">$125.50</td>
                        <td class="text-center"><span
                                class="status-badge bg-success-light text-success-custom">Lunas</span></td>
                    </tr>
                    <tr class="hover-bg-light">
                        <td class="text-primary-custom fw-medium">TRX-9874</td>
                        <td class="text-secondary">2023-10-23</td>
                        <td class="fw-medium">Consulting Fee</td>
                        <td class="text-secondary">StartUp One</td>
                        <td class="text-end fw-bold text-success-custom">+$850.00</td>
                        <td class="text-center"><span
                                class="status-badge bg-warning-light text-warning-custom">Pending</span></td>
                    </tr>
                    <tr class="hover-bg-light">
                        <td class="text-primary-custom fw-medium">TRX-9875</td>
                        <td class="text-secondary">2023-10-22</td>
                        <td class="fw-medium">Internet Bill</td>
                        <td class="text-secondary">Comcast</td>
                        <td class="text-end fw-bold text-dark">$89.99</td>
                        <td class="text-center"><span
                                class="status-badge bg-success-light text-success-custom">Lunas</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    // --- Charts Configuration (Chart.js) ---

    // Income Area Chart
    const ctxIncome = document.getElementById('incomeChart').getContext('2d');
    const gradientIncome = ctxIncome.createLinearGradient(0, 0, 0, 300);
    gradientIncome.addColorStop(0, 'rgba(43, 45, 143, 0.1)');
    gradientIncome.addColorStop(1, 'rgba(43, 45, 143, 0)');

    const gradientExpense = ctxIncome.createLinearGradient(0, 0, 0, 300);
    gradientExpense.addColorStop(0, 'rgba(234, 84, 85, 0.1)');
    gradientExpense.addColorStop(1, 'rgba(234, 84, 85, 0)');

    new Chart(ctxIncome, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                    label: 'Income',
                    data: [4000, 3000, 2000, 2780, 1890, 2390, 3490],
                    borderColor: '#2B2D8F',
                    backgroundColor: gradientIncome,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 6
                },
                {
                    label: 'Expense',
                    data: [2400, 1398, 9800, 3908, 4800, 3800, 4300],
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
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#2E2E3A',
                    bodyColor: '#5E6278',
                    borderColor: '#f0f0f0',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: true,
                    boxPadding: 4
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
                        }
                    }
                }
            }
        }
    });

    // Expense Breakdown Pie Chart
    const ctxExpense = document.getElementById('expenseChart').getContext('2d');
    new Chart(ctxExpense, {
        type: 'doughnut',
        data: {
            labels: ['Operational', 'Materials', 'Marketing', 'Salaries'],
            datasets: [{
                data: [400, 300, 300, 200],
                backgroundColor: ['#2B2D8F', '#28C76F', '#FF9F43', '#EA5455'],
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
                }
            }
        }
    });
</script>
@endsection
