<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bogalova</title>

    <!-- Fonts -->
    <!-- System UI used via CSS -->

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
</head>

<body>
    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="brand-wrapper">
                    <div class="logo-box">
                        <i data-lucide="wheat" class="text-white" style="width: 20px;"></i>
                    </div>
                    <span class="brand-text">Bogalova</span>
                </div>
            </div>

            <div class="sidebar-menu custom-scrollbar">
                <ul style="padding-left: 0; margin-bottom: 0;">

                    <!-- Dashboard -->
                    <li class="menu-item">
                        <div class="menu-link">
                            <div class="menu-left">
                                <i data-lucide="layout-dashboard" width="20"></i>
                                <a href="/dashboard" class="submenu-link"><span class="menu-text">Dashboard</span></a>
                            </div>
                        </div>
                    </li>

                    <!-- Master Data -->
                    <li class="menu-item has-submenu">
                        <div class="menu-link">
                            <div class="menu-left">
                                <i data-lucide="package" width="20"></i>
                                <span class="menu-text">Master Data</span>
                            </div>
                            <i data-lucide="chevron-right" width="16" class="menu-arrow"></i>
                        </div>

                        <ul class="submenu">
                            <li><a href="/akun" class="submenu-link">Akun</a></li>
                            <li><a href="/peruntukan" class="submenu-link">Peruntukan</a></li>
                            <li><a href="/satuan" class="submenu-link">Satuan</a></li>
                            <li><a href="/bahan" class="submenu-link">Bahan Baku</a></li>
                            <li><a href="/formula" class="submenu-link">Formula</a></li>
                            <li><a href="/customers" class="submenu-link">Customers</a></li>
                            <li><a href="/vendors" class="submenu-link">Vendors</a></li>
                            <li><a href="/outlets" class="submenu-link">Outlet</a></li>
                        </ul>
                    </li>

                    <!-- Transaksi -->
                    <li class="menu-item has-submenu">
                        <div class="menu-link">
                            <div class="menu-left">
                                <i data-lucide="wallet" width="20"></i>
                                <span class="menu-text">Transaksi</span>
                            </div>
                            <i data-lucide="chevron-right" width="16" class="menu-arrow"></i>
                        </div>

                        <ul class="submenu">
                            <!-- <li><a href="/rencana-produksi" class="submenu-link">Rencanan Produksi</a></li> -->
                            <!-- <li><a href="/piutang" class="submenu-link">Piutang</a></li> -->
                            <!-- <li><a href="/hutang" class="submenu-link">Hutang</a></li> -->
                            <li><a href="/pemasukan" class="submenu-link">Pemasukan</a></li>
                            <li><a href="/pengeluaran" class="submenu-link">Pengeluaran</a></li>
                        </ul>
                    </li>

                    <!-- Laporan -->
                    <li class="menu-item has-submenu">
                        <div class="menu-link">
                            <div class="menu-left">
                                <i data-lucide="line-chart" width="20"></i>
                                <span class="menu-text">Laporan</span>
                            </div>
                            <i data-lucide="chevron-right" width="16" class="menu-arrow"></i>
                        </div>

                        <ul class="submenu">
                            <li><a href="/laporan/pemasukan" class="submenu-link">Laporan Pemasukan</a></li>
                            <li><a href="/laporan/pengeluaran" class="submenu-link">Laporan Pengeluaran</a></li>
                        </ul>
                    </li>

                    <!-- Settings -->
                    <li class="menu-item">
                        <div class="menu-link">
                            <div class="menu-left">
                                <i data-lucide="settings" width="20"></i>
                                <span class="menu-text">Settings</span>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>


            <!-- Mini Profile (Visible only when collapsed on desktop conceptually, but simplified here) -->
            <div class="p-3 border-top border-white-10 d-none d-lg-flex justify-content-center">
                <!-- Content handled by JS if needed for collapse state -->
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Top Navbar -->
            <header class="top-nav">
                <div class="d-flex align-items-center gap-3">
                    <!-- <button class="btn btn-light border-0 p-2" onclick="toggleSidebar()">
                        <i data-lucide="menu" class="text-secondary"></i>
                    </button> -->
                    <button id="sidebarToggle" class="btn btn-light border-0 p-2 sidebar-toggle-btn">
                        <i data-lucide="menu"></i>
                    </button <h5 class="mb-0 d-none d-sm-block fw-bold text-dark">{{ $title }}</h5>

                    <!-- <div class="search-container d-none d-md-flex ms-3">
                        <i data-lucide="search" size="18" class="text-secondary"></i>
                        <input type="text" class="search-input" placeholder="Search...">
                        <span class="badge bg-white text-secondary border d-none d-lg-block"
                            style="font-size: 10px;">⌘K</span>
                    </div> -->
                </div>

                <div class="d-flex align-items-center gap-2 gap-sm-4">
                    <!-- <button class="icon-btn">
                        <i data-lucide="mail" width="20"></i>
                        <span class="badge-dot bg-danger"></span>
                    </button>
                    <button class="icon-btn">
                        <i data-lucide="bell" width="20"></i>
                        <span class="badge-dot bg-success"></span>
                    </button> -->

                    <div class="d-none d-sm-block bg-secondary opacity-25" style="width: 1px; height: 32px;"></div>

                    <div class="dropdown">
                        <div class="d-flex align-items-center gap-3 p-1 rounded hover-bg-light cursor-pointer"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                            <div class="text-end d-none d-sm-block line-height-sm">
                                <p class="mb-0 fw-semibold text-dark text-sm">{{ Auth::user()->name }}</p>
                                <p class="mb-0 text-secondary" style="font-size: 11px;">Admin</p>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm"
                                style="width: 36px; height: 36px; background-color: var(--primary);">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                                    href="{{ route('profile.edit') }}">
                                    <i data-lucide="user" width="18"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                                        <i data-lucide="log-out" width="18"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            @yield('content')

            <footer class="text-center mt-5 mb-3 text-secondary small">
                &copy; 2026 Bogalova. All rights reserved.
            </footer>
        </main>
    </div>

    <!-- Bootstrap 5 JS Bundle (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (must be loaded before Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Application Logic -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTables
            $('#dataTable').DataTable();
            $('.datatable').DataTable();

            // SweetAlert Delete Confirmation
            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
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
                })
            });
        });
    </script>

    @yield('scripts')
</body>

</html>