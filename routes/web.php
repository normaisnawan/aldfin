<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::resource('akun', \App\Http\Controllers\AkunController::class);
    Route::resource('peruntukan', \App\Http\Controllers\PeruntukanController::class);
    Route::resource('satuan', \App\Http\Controllers\SatuanController::class);
    Route::resource('bahan', \App\Http\Controllers\BahanController::class);
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);
    Route::resource('vendors', \App\Http\Controllers\VendorController::class);
    Route::resource('outlets', \App\Http\Controllers\OutletController::class);
    Route::resource('formula', \App\Http\Controllers\FormulaController::class);
    Route::post('formula/{formula}/item', [\App\Http\Controllers\FormulaController::class, 'storeItem'])->name('formula.item.store');
    Route::delete('formula/item/{formulaItem}', [\App\Http\Controllers\FormulaController::class, 'destroyItem'])->name('formula.item.destroy');
    Route::get('rencana-produksi/export/pdf', [\App\Http\Controllers\ProductionPlanController::class, 'exportPdf'])->name('rencana-produksi.export.pdf');
    Route::get('rencana-produksi/export/excel', [\App\Http\Controllers\ProductionPlanController::class, 'exportExcel'])->name('rencana-produksi.export.excel');
    Route::get('rencana-produksi/{plan}/export/pdf', [\App\Http\Controllers\ProductionPlanController::class, 'exportDetailPdf'])->name('rencana-produksi.detail.export.pdf');
    Route::get('rencana-produksi/{plan}/export/excel', [\App\Http\Controllers\ProductionPlanController::class, 'exportDetailExcel'])->name('rencana-produksi.detail.export.excel');
    Route::resource('rencana-produksi', \App\Http\Controllers\ProductionPlanController::class);
    Route::get('api/formula/{formula}', [\App\Http\Controllers\ProductionPlanController::class, 'getFormulaDetails']);

    // Pemasukan routes
    Route::get('pemasukan/{pemasukan}/print', [\App\Http\Controllers\PemasukanController::class, 'print'])->name('pemasukan.print');
    Route::resource('pemasukan', \App\Http\Controllers\PemasukanController::class);

    // Pengeluaran routes
    Route::get('pengeluaran/{pengeluaran}/payment', [\App\Http\Controllers\PengeluaranController::class, 'payment'])->name('pengeluaran.payment');
    Route::post('pengeluaran/{pengeluaran}/process-payment', [\App\Http\Controllers\PengeluaranController::class, 'processPayment'])->name('pengeluaran.process-payment');
    Route::get('pengeluaran/{pengeluaran}/print', [\App\Http\Controllers\PengeluaranController::class, 'print'])->name('pengeluaran.print');
    Route::resource('pengeluaran', \App\Http\Controllers\PengeluaranController::class);

    // Laporan routes
    Route::get('laporan/pemasukan', [\App\Http\Controllers\LaporanPemasukanController::class, 'index'])->name('laporan.pemasukan');
    Route::get('laporan/pemasukan/print', [\App\Http\Controllers\LaporanPemasukanController::class, 'exportPdf'])->name('laporan.pemasukan.print');
    Route::get('laporan/pemasukan/excel', [\App\Http\Controllers\LaporanPemasukanController::class, 'exportExcel'])->name('laporan.pemasukan.excel');
    Route::get('laporan/pengeluaran', [\App\Http\Controllers\LaporanPengeluaranController::class, 'index'])->name('laporan.pengeluaran');
    Route::get('laporan/pengeluaran/print', [\App\Http\Controllers\LaporanPengeluaranController::class, 'exportPdf'])->name('laporan.pengeluaran.print');
    Route::get('laporan/pengeluaran/excel', [\App\Http\Controllers\LaporanPengeluaranController::class, 'exportExcel'])->name('laporan.pengeluaran.excel');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
