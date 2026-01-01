<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaItem extends Model
{
  use HasFactory;

  protected $fillable = [
    'formula_id',
    'bahan_id',
    'qty',
  ];

  public function bahan()
  {
    return $this->belongsTo(Bahan::class);
  }
}
