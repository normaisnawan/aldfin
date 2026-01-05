<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiKeuangan extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'tanggal',
    'jenis',
    'akun_id',
    'outlet_id',
    'jumlah',
    'keterangan',
    'sumber',
    'referensi_id',
    'user_id',
  ];

  protected $casts = [
    'tanggal' => 'date',
    'jumlah' => 'decimal:2',
  ];

  public function akun()
  {
    return $this->belongsTo(Akun::class);
  }

  public function outlet()
  {
    return $this->belongsTo(Outlet::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function scopePemasukan($query)
  {
    return $query->where('jenis', 'pemasukan');
  }

  public function scopePengeluaran($query)
  {
    return $query->where('jenis', 'pengeluaran');
  }
}
