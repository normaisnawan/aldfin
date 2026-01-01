<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionPlanItem extends Model
{
  use HasFactory;

  protected $fillable = [
    'production_plan_id',
    'bahan_id',
    'qty_per_porsi',
    'total_qty',
  ];

  public function plan()
  {
    return $this->belongsTo(ProductionPlan::class, 'production_plan_id');
  }

  public function bahan()
  {
    return $this->belongsTo(Bahan::class);
  }
}
