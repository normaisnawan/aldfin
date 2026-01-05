<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use App\Models\TransaksiKeuangan;
use App\Models\Akun;
use App\Models\Outlet;
use App\Models\Peruntukan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
  protected string $title;

  public function __construct()
  {
    $this->title = 'Pengeluaran';
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $pengeluarans = Pengeluaran::with(['akun', 'outlet', 'peruntukan'])
      ->orderBy('tanggal', 'desc')
      ->orderBy('created_at', 'desc')
      ->get();
    $title = $this->title;
    return view('pengeluaran.index', compact('pengeluarans', 'title'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $akuns = Akun::where('tipe_akun', 'Pengeluaran')->orderBy('nama_akun')->get();
    $outlets = Outlet::orderBy('nama')->get();
    $peruntukans = Peruntukan::orderBy('nama')->get();
    return view('pengeluaran.create', [
      'title' => $this->title,
      'akuns' => $akuns,
      'outlets' => $outlets,
      'peruntukans' => $peruntukans,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'tanggal' => 'required|date',
      'akun_id' => 'required|exists:akuns,id',
      'outlet_id' => 'required|exists:outlets,id',
      'peruntukan_id' => 'nullable|exists:peruntukans,id',
      'jumlah' => 'required|numeric',
      'keterangan' => 'nullable|string',
    ]);

    Pengeluaran::create([
      'nomor_transaksi' => Pengeluaran::generateNomorTransaksi(),
      'tanggal' => $request->tanggal,
      'akun_id' => $request->akun_id,
      'outlet_id' => $request->outlet_id,
      'peruntukan_id' => $request->peruntukan_id,
      'user_id' => Auth::id(),
      'jumlah' => $request->jumlah,
      'keterangan' => $request->keterangan,
      'status' => 'unpaid',
    ]);

    return redirect()->route('pengeluaran.index')
      ->with('success', 'Pengeluaran berhasil ditambahkan.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Pengeluaran $pengeluaran)
  {
    $pengeluaran->load(['akun', 'outlet', 'transaksiKeuangan', 'peruntukan']);
    $title = $this->title;
    return view('pengeluaran.show', compact('pengeluaran', 'title'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Pengeluaran $pengeluaran)
  {
    // Block edit if already paid
    if ($pengeluaran->isPaid()) {
      return redirect()->route('pengeluaran.index')
        ->with('error', 'Pengeluaran yang sudah dibayar tidak dapat diedit.');
    }

    $akuns = Akun::where('tipe_akun', 'Pengeluaran')->orderBy('nama_akun')->get();
    $outlets = Outlet::orderBy('nama')->get();
    $peruntukans = Peruntukan::orderBy('nama')->get();
    $title = $this->title;
    return view('pengeluaran.edit', compact('pengeluaran', 'akuns', 'outlets', 'peruntukans', 'title'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Pengeluaran $pengeluaran)
  {
    // Block update if already paid
    if ($pengeluaran->isPaid()) {
      return redirect()->route('pengeluaran.index')
        ->with('error', 'Pengeluaran yang sudah dibayar tidak dapat diedit.');
    }

    $request->validate([
      'tanggal' => 'required|date',
      'akun_id' => 'required|exists:akuns,id',
      'outlet_id' => 'required|exists:outlets,id',
      'peruntukan_id' => 'nullable|exists:peruntukans,id',
      'jumlah' => 'required|numeric',
      'keterangan' => 'nullable|string',
    ]);

    $pengeluaran->update([
      'tanggal' => $request->tanggal,
      'akun_id' => $request->akun_id,
      'outlet_id' => $request->outlet_id,
      'peruntukan_id' => $request->peruntukan_id,
      'jumlah' => $request->jumlah,
      'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('pengeluaran.index')
      ->with('success', 'Pengeluaran berhasil diperbarui.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Pengeluaran $pengeluaran)
  {
    // Block delete if already paid
    if ($pengeluaran->isPaid()) {
      return redirect()->route('pengeluaran.index')
        ->with('error', 'Pengeluaran yang sudah dibayar tidak dapat dihapus.');
    }

    $pengeluaran->delete();

    return redirect()->route('pengeluaran.index')
      ->with('success', 'Pengeluaran berhasil dihapus.');
  }

  /**
   * Show payment confirmation page.
   */
  public function payment(Pengeluaran $pengeluaran)
  {
    // Check if already paid
    if ($pengeluaran->isPaid()) {
      return redirect()->route('pengeluaran.index')
        ->with('error', 'Pengeluaran ini sudah dibayar.');
    }

    $pengeluaran->load(['akun', 'outlet']);
    $title = $this->title;
    return view('pengeluaran.payment', compact('pengeluaran', 'title'));
  }

  /**
   * Process payment for the pengeluaran.
   */
  public function processPayment(Request $request, Pengeluaran $pengeluaran)
  {
    // Check if already paid
    if ($pengeluaran->isPaid()) {
      return redirect()->route('pengeluaran.index')
        ->with('error', 'Pengeluaran ini sudah dibayar.');
    }

    DB::beginTransaction();

    try {
      // Create record in transaksi_keuangans
      $transaksi = TransaksiKeuangan::create([
        'tanggal' => $pengeluaran->tanggal,
        'jenis' => 'pengeluaran',
        'akun_id' => $pengeluaran->akun_id,
        'outlet_id' => $pengeluaran->outlet_id,
        'jumlah' => $pengeluaran->jumlah,
        'keterangan' => $pengeluaran->keterangan,
        'sumber' => 'pengeluaran',
        'referensi_id' => $pengeluaran->id,
        'user_id' => Auth::id(),
      ]);

      // Update pengeluaran status
      $pengeluaran->update([
        'status' => 'paid',
        'paid_at' => now(),
        'transaksi_keuangan_id' => $transaksi->id,
      ]);

      DB::commit();

      return redirect()->route('pengeluaran.index')
        ->with('success', 'Pembayaran berhasil diproses. Pengeluaran telah dicatat ke transaksi keuangan.');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->route('pengeluaran.index')
        ->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
    }
  }

  /**
   * Print pengeluaran document.
   */
  public function print(Pengeluaran $pengeluaran)
  {
    $pengeluaran->load(['akun', 'outlet', 'peruntukan']);
    $title = $this->title;
    return view('pengeluaran.print', compact('pengeluaran', 'title'));
  }
}
