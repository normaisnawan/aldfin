<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use App\Models\Akun;
use App\Models\Outlet;
use App\Models\Peruntukan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanPengeluaranController extends Controller
{
    protected string $title;

    public function __construct()
    {
        $this->title = 'Laporan Pengeluaran';
    }

    /**
     * Display the expense report.
     */
    public function index(Request $request)
    {
        $title = $this->title;

        // Get filter parameters
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $akunId = $request->get('akun_id');
        $outletId = $request->get('outlet_id');
        $peruntukanId = $request->get('peruntukan_id');
        $status = $request->get('status');
        $nomorTransaksi = $request->get('nomor_transaksi');
        $minAmount = $request->get('min_amount');
        $maxAmount = $request->get('max_amount');

        // Build query
        $query = Pengeluaran::with(['akun', 'outlet', 'peruntukan'])
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($akunId) {
            $query->where('akun_id', $akunId);
        }

        if ($outletId) {
            $query->where('outlet_id', $outletId);
        }

        if ($peruntukanId) {
            $query->where('peruntukan_id', $peruntukanId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($nomorTransaksi) {
            $query->where('nomor_transaksi', 'like', "%{$nomorTransaksi}%");
        }

        if ($minAmount) {
            $query->where('jumlah', '>=', $minAmount);
        }

        if ($maxAmount) {
            $query->where('jumlah', '<=', $maxAmount);
        }

        $pengeluarans = $query->orderBy('tanggal', 'desc')->get();

        // Calculate summary
        $totalPaid = $pengeluarans->where('status', 'paid')->sum('jumlah');
        $totalUnpaid = $pengeluarans->where('status', 'unpaid')->sum('jumlah');

        $summary = [
            'total' => $pengeluarans->sum('jumlah'),
            'total_paid' => $totalPaid,
            'total_unpaid' => $totalUnpaid,
            'count' => $pengeluarans->count(),
            'count_paid' => $pengeluarans->where('status', 'paid')->count(),
            'count_unpaid' => $pengeluarans->where('status', 'unpaid')->count(),
            'average' => $pengeluarans->count() > 0 ? $pengeluarans->avg('jumlah') : 0,
            'max' => $pengeluarans->max('jumlah') ?? 0,
            'min' => $pengeluarans->min('jumlah') ?? 0,
        ];

        // Chart data - by date
        $chartByDate = $pengeluarans->groupBy(function ($item) {
            return $item->tanggal->format('Y-m-d');
        })->map(function ($group) {
            return $group->sum('jumlah');
        })->sortKeys();

        // Chart data - by akun
        $chartByAkun = $pengeluarans->groupBy('akun_id')->map(function ($group) {
            return [
                'nama' => $group->first()->akun->nama_akun,
                'total' => $group->sum('jumlah'),
            ];
        })->values();

        // Chart data - by status
        $chartByStatus = [
            ['status' => 'Paid', 'total' => $totalPaid],
            ['status' => 'Unpaid', 'total' => $totalUnpaid],
        ];

        // Get filter options
        $akuns = Akun::where('tipe_akun', 'Pengeluaran')->orderBy('nama_akun')->get();
        $outlets = Outlet::orderBy('nama')->get();
        $peruntukans = Peruntukan::orderBy('nama')->get();

        return view('laporan.pengeluaran.index', compact(
            'title',
            'pengeluarans',
            'summary',
            'chartByDate',
            'chartByAkun',
            'chartByStatus',
            'akuns',
            'outlets',
            'peruntukans',
            'startDate',
            'endDate',
            'akunId',
            'outletId',
            'peruntukanId',
            'status',
            'nomorTransaksi',
            'minAmount',
            'maxAmount'
        ));
    }

    /**
     * Export to PDF.
     */
    public function exportPdf(Request $request)
    {
        // Get data with same filters
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $query = Pengeluaran::with(['akun', 'outlet', 'peruntukan'])
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($request->get('akun_id')) {
            $query->where('akun_id', $request->get('akun_id'));
        }

        if ($request->get('outlet_id')) {
            $query->where('outlet_id', $request->get('outlet_id'));
        }

        if ($request->get('status')) {
            $query->where('status', $request->get('status'));
        }

        $pengeluarans = $query->orderBy('tanggal', 'desc')->get();

        $summary = [
            'total' => $pengeluarans->sum('jumlah'),
            'total_paid' => $pengeluarans->where('status', 'paid')->sum('jumlah'),
            'total_unpaid' => $pengeluarans->where('status', 'unpaid')->sum('jumlah'),
            'count' => $pengeluarans->count(),
            'average' => $pengeluarans->count() > 0 ? $pengeluarans->avg('jumlah') : 0,
        ];

        $title = 'Laporan Pengeluaran';

        return view('laporan.pengeluaran.print', compact('title', 'pengeluarans', 'summary', 'startDate', 'endDate'));
    }

    /**
     * Export to Excel.
     */
    public function exportExcel(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $akunId = $request->get('akun_id');
        $outletId = $request->get('outlet_id');
        $status = $request->get('status');
        $nomorTransaksi = $request->get('nomor_transaksi');
        $minAmount = $request->get('min_amount');
        $maxAmount = $request->get('max_amount');

        $filename = 'laporan-pengeluaran-' . $startDate . '-' . $endDate . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LaporanPengeluaranExport(
                $startDate,
                $endDate,
                $akunId,
                $outletId,
                $status,
                $nomorTransaksi,
                $minAmount,
                $maxAmount
            ),
            $filename
        );
    }
}
