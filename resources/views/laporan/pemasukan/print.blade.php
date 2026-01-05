<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Pemasukan</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-size: 12px;
      line-height: 1.5;
      color: #333;
      padding: 20px;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
    }

    .header {
      text-align: center;
      border-bottom: 2px solid #333;
      padding-bottom: 15px;
      margin-bottom: 20px;
    }

    .header h1 {
      font-size: 20px;
      margin-bottom: 5px;
    }

    .header h2 {
      font-size: 16px;
      color: #28a745;
    }

    .period {
      text-align: center;
      margin-bottom: 20px;
      color: #666;
    }

    .summary-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .summary-table td {
      padding: 8px 15px;
      border: 1px solid #ddd;
    }

    .summary-table .label {
      background: #f8f9fa;
      font-weight: 600;
      width: 200px;
    }

    .summary-table .value {
      text-align: right;
      font-weight: bold;
    }

    .summary-table .value.success {
      color: #28a745;
    }

    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .data-table th,
    .data-table td {
      padding: 8px 10px;
      border: 1px solid #ddd;
      text-align: left;
    }

    .data-table th {
      background: #f8f9fa;
      font-weight: 600;
    }

    .data-table .text-end {
      text-align: right;
    }

    .data-table .text-success {
      color: #28a745;
    }

    .data-table tfoot td {
      font-weight: bold;
      background: #e9ecef;
    }

    .print-date {
      text-align: right;
      color: #666;
      font-size: 11px;
      margin-top: 30px;
    }

    .no-print {
      margin-top: 30px;
      text-align: center;
    }

    @media print {
      .no-print {
        display: none;
      }

      body {
        padding: 0;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>ALDILA FINANCE</h1>
      <h2>LAPORAN PEMASUKAN</h2>
    </div>

    <div class="period">
      Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d
      {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
    </div>

    <table class="summary-table">
      <tr>
        <td class="label">Total Pemasukan</td>
        <td class="value success">Rp {{ number_format($summary['total'], 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="label">Jumlah Transaksi</td>
        <td class="value">{{ number_format($summary['count']) }} transaksi</td>
      </tr>
      <tr>
        <td class="label">Rata-rata per Transaksi</td>
        <td class="value">Rp {{ number_format($summary['average'], 0, ',', '.') }}</td>
      </tr>
    </table>

    <table class="data-table">
      <thead>
        <tr>
          <th>No</th>
          <th>No. Transaksi</th>
          <th>Tanggal</th>
          <th>Akun</th>
          <th>Outlet</th>
          <th class="text-end">Jumlah</th>
          <th>Peruntukan</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($pemasukans as $index => $pemasukan)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $pemasukan->nomor_transaksi }}</td>
            <td>{{ $pemasukan->tanggal->format('d/m/Y') }}</td>
            <td>{{ $pemasukan->akun->nama_akun }}</td>
            <td>{{ $pemasukan->outlet->nama }}</td>
            <td class="text-end text-success">Rp {{ number_format($pemasukan->jumlah, 0, ',', '.') }}</td>
            <td>{{ $pemasukan->peruntukan->nama ?? '-' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="text-align: center;">Tidak ada data</td>
          </tr>
        @endforelse
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5" class="text-end">TOTAL:</td>
          <td class="text-end text-success">Rp {{ number_format($summary['total'], 0, ',', '.') }}</td>
          <td></td>
        </tr>
      </tfoot>
    </table>

    <div class="print-date">
      Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>

    <div class="no-print">
      <button onclick="window.print()"
        style="padding: 10px 20px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
        Cetak Laporan
      </button>
      <button onclick="window.close()"
        style="padding: 10px 20px; background: #6c757d; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">
        Tutup
      </button>
    </div>
  </div>
</body>

</html>