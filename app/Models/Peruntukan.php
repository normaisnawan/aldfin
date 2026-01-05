<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peruntukan extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'nama',
    'deskripsi',
  ];

  public function pemasukans()
  {
    return $this->hasMany(Pemasukan::class);
  }

  public function pengeluarans()
  {
    return $this->hasMany(Pengeluaran::class);
  }
}
