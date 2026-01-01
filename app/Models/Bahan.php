<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bahan extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = ['nama', 'satuan_id'];

  public function satuan()
  {
    return $this->belongsTo(Satuan::class);
  }
}
