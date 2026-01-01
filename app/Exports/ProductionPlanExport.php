<?php

namespace App\Exports;

use App\Models\ProductionPlan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductionPlanExport implements FromCollection, WithHeadings, WithMapping
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return ProductionPlan::with(['customer', 'formula'])->get();
  }

  public function headings(): array
  {
    return [
      'ID Rencana',
      'Tanggal',
      'Customer',
      'Menu',
      'Porsi',
      'Status',
      'Dibuat Pada',
    ];
  }

  public function map($plan): array
  {
    return [
      $plan->nomor_rencana ?? 'RP-' . str_pad($plan->id, 6, '0', STR_PAD_LEFT),
      $plan->tanggal,
      $plan->customer->nama,
      $plan->formula->nama,
      $plan->porsi,
      $plan->status,
      $plan->created_at->format('d-m-Y H:i'),
    ];
  }
}
