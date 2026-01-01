<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formula extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'nama',
    'deskripsi',
  ];

  public function items()
  {
    return $this->hasMany(FormulaItem::class);
  }
}
