<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\TransaksiKeuangan;
use App\Models\Akun;
use App\Models\Outlet;
use App\Models\Peruntukan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PemasukanController extends Controller
{
  protected string $title;

  public function __construct()
  {
    $this->title = 'Pemasukan';
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $pemasukans = Pemasukan::with(['akun', 'outlet', 'peruntukan'])
      ->orderBy('tanggal', 'desc')
      ->orderBy('created_at', 'desc')
      ->get();
    $title = $this->title;
    return view('pemasukan.index', compact('pemasukans', 'title'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $akuns = Akun::where('tipe_akun', 'Pemasukan')->orderBy('nama_akun')->get();
    $outlets = Outlet::orderBy('nama')->get();
    $peruntukans = Peruntukan::orderBy('nama')->get();
    return view('pemasukan.create', [
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

    DB::beginTransaction();

    try {
      // Generate nomor transaksi
      $nomorTransaksi = Pemasukan::generateNomorTransaksi();

      // Create record in transaksi_keuangans
      $transaksi = TransaksiKeuangan::create([
        'tanggal' => $request->tanggal,
        'jenis' => 'pemasukan',
        'akun_id' => $request->akun_id,
        'outlet_id' => $request->outlet_id,
        'jumlah' => $request->jumlah,
        'keterangan' => $request->keterangan,
        'sumber' => 'pemasukan',
        'user_id' => Auth::id(),
      ]);

      // Create record in pemasukans table
      Pemasukan::create([
        'nomor_transaksi' => $nomorTransaksi,
        'tanggal' => $request->tanggal,
        'akun_id' => $request->akun_id,
        'outlet_id' => $request->outlet_id,
        'peruntukan_id' => $request->peruntukan_id,
        'user_id' => Auth::id(),
        'jumlah' => $request->jumlah,
        'keterangan' => $request->keterangan,
        'status' => 'paid',
        'paid_at' => now(),
        'transaksi_keuangan_id' => $transaksi->id,
      ]);

      DB::commit();

      return redirect()->route('pemasukan.index')
        ->with('success', 'Pemasukan berhasil ditambahkan dan dicatat ke transaksi keuangan.');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->route('pemasukan.create')
        ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Pemasukan $pemasukan)
  {
    $pemasukan->load(['akun', 'outlet', 'transaksiKeuangan', 'peruntukan']);
    $title = $this->title;
    return view('pemasukan.show', compact('pemasukan', 'title'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Pemasukan $pemasukan)
  {
    // Pemasukan bersifat final (paid), tidak bisa diedit
    return redirect()->route('pemasukan.index')
      ->with('error', 'Pemasukan yang sudah tercatat tidak dapat diedit.');
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Pemasukan $pemasukan)
  {
    // Pemasukan bersifat final (paid), tidak bisa di-update
    return redirect()->route('pemasukan.index')
      ->with('error', 'Pemasukan yang sudah tercatat tidak dapat diedit.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Pemasukan $pemasukan)
  {
    // Pemasukan bersifat final (paid), tidak bisa dihapus
    return redirect()->route('pemasukan.index')
      ->with('error', 'Pemasukan yang sudah tercatat tidak dapat dihapus.');
  }

  /**
   * Print pemasukan document.
   */
  public function print(Pemasukan $pemasukan)
  {
    $pemasukan->load(['akun', 'outlet', 'peruntukan']);
    $title = $this->title;
    return view('pemasukan.print', compact('pemasukan', 'title'));
  }
}
