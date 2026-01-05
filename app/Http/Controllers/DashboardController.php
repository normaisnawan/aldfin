<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\TransaksiKeuangan;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';

        // Get current month data
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $lastMonth = now()->subMonth()->month;
        $lastMonthYear = now()->subMonth()->year;

        // Total Pemasukan (paid only)
        $totalPemasukan = Pemasukan::where('status', 'paid')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('jumlah');

        $lastMonthPemasukan = Pemasukan::where('status', 'paid')
            ->whereMonth('tanggal', $lastMonth)
            ->whereYear('tanggal', $lastMonthYear)
            ->sum('jumlah');

        // Total Pengeluaran (paid only)
        $totalPengeluaran = Pengeluaran::where('status', 'paid')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('jumlah');

        $lastMonthPengeluaran = Pengeluaran::where('status', 'paid')
            ->whereMonth('tanggal', $lastMonth)
            ->whereYear('tanggal', $lastMonthYear)
            ->sum('jumlah');

        // Saldo Kas (Total pemasukan - Total pengeluaran - all time)
        $totalAllTimePemasukan = Pemasukan::where('status', 'paid')->sum('jumlah');
        $totalAllTimePengeluaran = Pengeluaran::where('status', 'paid')->sum('jumlah');
        $saldoKas = $totalAllTimePemasukan - $totalAllTimePengeluaran;

        // Last month Saldo
        $lastMonthAllTimePemasukan = Pemasukan::where('status', 'paid')
            ->where(function ($q) use ($lastMonth, $lastMonthYear) {
                $q->whereYear('tanggal', '<', $lastMonthYear)
                    ->orWhere(function ($q2) use ($lastMonth, $lastMonthYear) {
                        $q2->whereYear('tanggal', $lastMonthYear)
                            ->whereMonth('tanggal', '<=', $lastMonth);
                    });
            })->sum('jumlah');

        $lastMonthAllTimePengeluaran = Pengeluaran::where('status', 'paid')
            ->where(function ($q) use ($lastMonth, $lastMonthYear) {
                $q->whereYear('tanggal', '<', $lastMonthYear)
                    ->orWhere(function ($q2) use ($lastMonth, $lastMonthYear) {
                        $q2->whereYear('tanggal', $lastMonthYear)
                            ->whereMonth('tanggal', '<=', $lastMonth);
                    });
            })->sum('jumlah');

        $lastMonthSaldoKas = $lastMonthAllTimePemasukan - $lastMonthAllTimePengeluaran;

        // Laba Bersih (current month)
        $labaBersih = $totalPemasukan - $totalPengeluaran;
        $lastMonthLabaBersih = $lastMonthPemasukan - $lastMonthPengeluaran;

        // Calculate percentage changes
        $saldoKasChange = $lastMonthSaldoKas > 0 ? (($saldoKas - $lastMonthSaldoKas) / $lastMonthSaldoKas) * 100 : 0;
        $pemasukanChange = $lastMonthPemasukan > 0 ? (($totalPemasukan - $lastMonthPemasukan) / $lastMonthPemasukan) * 100 : 0;
        $pengeluaranChange = $lastMonthPengeluaran > 0 ? (($totalPengeluaran - $lastMonthPengeluaran) / $lastMonthPengeluaran) * 100 : 0;
        $labaBersihChange = $lastMonthLabaBersih != 0 ? (($labaBersih - $lastMonthLabaBersih) / abs($lastMonthLabaBersih)) * 100 : 0;

        // Recent Transactions (last 10)
        $recentTransactions = TransaksiKeuangan::with(['akun', 'outlet'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Chart data - last 6 months
        $chartLabels = [];
        $chartPemasukan = [];
        $chartPengeluaran = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabels[] = $date->format('M');

            $chartPemasukan[] = Pemasukan::where('status', 'paid')
                ->whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->sum('jumlah');

            $chartPengeluaran[] = Pengeluaran::where('status', 'paid')
                ->whereMonth('tanggal', $date->month)
                ->whereYear('tanggal', $date->year)
                ->sum('jumlah');
        }

        // Expense breakdown by akun (for pie chart)
        $expenseBreakdown = Pengeluaran::where('status', 'paid')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->with('akun')
            ->get()
            ->groupBy('akun_id')
            ->map(function ($items, $akunId) {
                return [
                    'akun' => $items->first()->akun->nama_akun ?? 'Unknown',
                    'total' => $items->sum('jumlah')
                ];
            })
            ->values();

        return view('dashboard', compact(
            'title',
            'saldoKas',
            'totalPemasukan',
            'totalPengeluaran',
            'labaBersih',
            'saldoKasChange',
            'pemasukanChange',
            'pengeluaranChange',
            'labaBersihChange',
            'recentTransactions',
            'chartLabels',
            'chartPemasukan',
            'chartPengeluaran',
            'expenseBreakdown'
        ));
    }
}
