<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'nomor_transaksi',
    'tanggal',
    'akun_id',
    'outlet_id',
    'peruntukan_id',
    'user_id',
    'jumlah',
    'keterangan',
    'lampiran',
    'status',
    'paid_at',
    'transaksi_keuangan_id',
  ];

  protected $casts = [
    'tanggal' => 'date',
    'jumlah' => 'decimal:2',
    'paid_at' => 'datetime',
  ];

  protected $attributes = [
    'status' => 'unpaid',
  ];

  /**
   * Generate nomor transaksi otomatis dengan format TROUT-YY-XXXXX
   * YY = 2 digit tahun berjalan
   * XXXXX = 5 digit nomor urut (reset setiap tahun berganti)
   */
  public static function generateNomorTransaksi(): string
  {
    $year = date('y'); // 2 digit tahun (contoh: 26 untuk 2026)
    $prefix = "TROUT-{$year}-";

    // Cari nomor urut terakhir untuk tahun ini
    $lastTransaction = self::withTrashed()
      ->where('nomor_transaksi', 'like', $prefix . '%')
      ->orderBy('nomor_transaksi', 'desc')
      ->first();

    if ($lastTransaction) {
      // Ambil 5 digit terakhir dan increment
      $lastNumber = (int) substr($lastTransaction->nomor_transaksi, -5);
      $newNumber = $lastNumber + 1;
    } else {
      // Mulai dari 1 jika belum ada transaksi tahun ini
      $newNumber = 1;
    }

    // Format dengan 5 digit (contoh: 00001)
    return $prefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
  }

  public function akun()
  {
    return $this->belongsTo(Akun::class);
  }

  public function outlet()
  {
    return $this->belongsTo(Outlet::class);
  }

  public function peruntukan()
  {
    return $this->belongsTo(Peruntukan::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function transaksiKeuangan()
  {
    return $this->belongsTo(TransaksiKeuangan::class);
  }

  public function scopeUnpaid($query)
  {
    return $query->where('status', 'unpaid');
  }

  public function scopePaid($query)
  {
    return $query->where('status', 'paid');
  }

  public function isPaid()
  {
    return $this->status === 'paid';
  }

  public function isUnpaid()
  {
    return $this->status === 'unpaid';
  }
}
