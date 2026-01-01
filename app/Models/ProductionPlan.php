<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionPlan extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'nomor_rencana',
    'customer_id',
    'formula_id',
    'tanggal',
    'porsi',
    'status',
  ];

  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function formula()
  {
    return $this->belongsTo(Formula::class);
  }

  public function items()
  {
    return $this->hasMany(ProductionPlanItem::class);
  }
}
