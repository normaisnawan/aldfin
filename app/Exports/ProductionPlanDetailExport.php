<?php

namespace App\Exports;

use App\Models\ProductionPlanItem;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductionPlanDetailExport implements FromQuery, WithHeadings, WithMapping
{
  protected $planId;

  public function __construct($planId)
  {
    $this->planId = $planId;
  }

  public function query()
  {
    return ProductionPlanItem::query()
      ->where('production_plan_id', $this->planId)
      ->with(['bahan.satuan']);
  }

  public function headings(): array
  {
    return [
      'Nama Bahan',
      'Qty Per Porsi',
      'Total Qty',
      'Satuan',
    ];
  }

  public function map($item): array
  {
    return [
      $item->bahan->nama,
      $item->qty_per_porsi,
      $item->total_qty,
      $item->bahan->satuan->nama,
    ];
  }
}
