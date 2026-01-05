<?php

namespace App\Exports;

use App\Models\Pemasukan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanPemasukanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
  protected $startDate;
  protected $endDate;
  protected $akunId;
  protected $outletId;
  protected $nomorTransaksi;
  protected $minAmount;
  protected $maxAmount;

  public function __construct($startDate, $endDate, $akunId = null, $outletId = null, $nomorTransaksi = null, $minAmount = null, $maxAmount = null)
  {
    $this->startDate = $startDate;
    $this->endDate = $endDate;
    $this->akunId = $akunId;
    $this->outletId = $outletId;
    $this->nomorTransaksi = $nomorTransaksi;
    $this->minAmount = $minAmount;
    $this->maxAmount = $maxAmount;
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    $query = Pemasukan::with(['akun', 'outlet', 'peruntukan'])
      ->whereBetween('tanggal', [$this->startDate, $this->endDate]);

    if ($this->akunId) {
      $query->where('akun_id', $this->akunId);
    }

    if ($this->outletId) {
      $query->where('outlet_id', $this->outletId);
    }

    if ($this->nomorTransaksi) {
      $query->where('nomor_transaksi', 'like', "%{$this->nomorTransaksi}%");
    }

    if ($this->minAmount) {
      $query->where('jumlah', '>=', $this->minAmount);
    }

    if ($this->maxAmount) {
      $query->where('jumlah', '<=', $this->maxAmount);
    }

    return $query->orderBy('tanggal', 'desc')->get();
  }

  public function headings(): array
  {
    return [
      'No. Transaksi',
      'Tanggal',
      'Kode Akun',
      'Nama Akun',
      'Outlet',
      'Jumlah',
      'Peruntukan',
    ];
  }

  public function map($pemasukan): array
  {
    return [
      $pemasukan->nomor_transaksi,
      $pemasukan->tanggal->format('d/m/Y'),
      $pemasukan->akun->kode_akun,
      $pemasukan->akun->nama_akun,
      $pemasukan->outlet->nama,
      $pemasukan->jumlah,
      $pemasukan->peruntukan->nama ?? '-',
    ];
  }

  public function styles(Worksheet $sheet)
  {
    return [
      1 => [
        'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
          'startColor' => ['rgb' => '28a745']
        ],
      ],
    ];
  }
}
