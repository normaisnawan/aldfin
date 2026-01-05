<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Akun;
use App\Models\Outlet;
use App\Models\Peruntukan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanPemasukanController extends Controller
{
    protected string $title;

    public function __construct()
    {
        $this->title = 'Laporan Pemasukan';
    }

    /**
     * Display the income report.
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
        $nomorTransaksi = $request->get('nomor_transaksi');
        $minAmount = $request->get('min_amount');
        $maxAmount = $request->get('max_amount');

        // Build query
        $query = Pemasukan::with(['akun', 'outlet', 'peruntukan'])
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

        if ($nomorTransaksi) {
            $query->where('nomor_transaksi', 'like', "%{$nomorTransaksi}%");
        }

        if ($minAmount) {
            $query->where('jumlah', '>=', $minAmount);
        }

        if ($maxAmount) {
            $query->where('jumlah', '<=', $maxAmount);
        }

        $pemasukans = $query->orderBy('tanggal', 'desc')->get();

        // Calculate summary
        $summary = [
            'total' => $pemasukans->sum('jumlah'),
            'count' => $pemasukans->count(),
            'average' => $pemasukans->count() > 0 ? $pemasukans->avg('jumlah') : 0,
            'max' => $pemasukans->max('jumlah') ?? 0,
            'min' => $pemasukans->min('jumlah') ?? 0,
        ];

        // Chart data - by date
        $chartByDate = $pemasukans->groupBy(function ($item) {
            return $item->tanggal->format('Y-m-d');
        })->map(function ($group) {
            return $group->sum('jumlah');
        })->sortKeys();

        // Chart data - by akun
        $chartByAkun = $pemasukans->groupBy('akun_id')->map(function ($group) {
            return [
                'nama' => $group->first()->akun->nama_akun,
                'total' => $group->sum('jumlah'),
            ];
        })->values();

        // Get filter options
        $akuns = Akun::where('tipe_akun', 'Pemasukan')->orderBy('nama_akun')->get();
        $outlets = Outlet::orderBy('nama')->get();
        $peruntukans = Peruntukan::orderBy('nama')->get();

        return view('laporan.pemasukan.index', compact(
            'title',
            'pemasukans',
            'summary',
            'chartByDate',
            'chartByAkun',
            'akuns',
            'outlets',
            'peruntukans',
            'startDate',
            'endDate',
            'akunId',
            'outletId',
            'peruntukanId',
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

        $query = Pemasukan::with(['akun', 'outlet', 'peruntukan'])
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($request->get('akun_id')) {
            $query->where('akun_id', $request->get('akun_id'));
        }

        if ($request->get('outlet_id')) {
            $query->where('outlet_id', $request->get('outlet_id'));
        }

        $pemasukans = $query->orderBy('tanggal', 'desc')->get();

        $summary = [
            'total' => $pemasukans->sum('jumlah'),
            'count' => $pemasukans->count(),
            'average' => $pemasukans->count() > 0 ? $pemasukans->avg('jumlah') : 0,
        ];

        $title = 'Laporan Pemasukan';

        return view('laporan.pemasukan.print', compact('title', 'pemasukans', 'summary', 'startDate', 'endDate'));
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
        $nomorTransaksi = $request->get('nomor_transaksi');
        $minAmount = $request->get('min_amount');
        $maxAmount = $request->get('max_amount');

        $filename = 'laporan-pemasukan-' . $startDate . '-' . $endDate . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LaporanPemasukanExport(
                $startDate,
                $endDate,
                $akunId,
                $outletId,
                $nomorTransaksi,
                $minAmount,
                $maxAmount
            ),
            $filename
        );
    }
}
