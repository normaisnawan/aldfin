<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print Pemasukan - {{ $pemasukan->nomor_transaksi }}</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-size: 14px;
      line-height: 1.6;
      color: #333;
      padding: 20px;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
    }

    .header {
      text-align: center;
      border-bottom: 2px solid #333;
      padding-bottom: 15px;
      margin-bottom: 20px;
    }

    .header h1 {
      font-size: 24px;
      margin-bottom: 5px;
    }

    .header p {
      color: #666;
    }

    .document-title {
      text-align: center;
      margin-bottom: 25px;
    }

    .document-title h2 {
      font-size: 18px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .status-badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: bold;
      text-transform: uppercase;
      margin-top: 5px;
    }

    .status-paid {
      background: #28a745;
      color: #fff;
    }

    .detail-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .detail-table td {
      padding: 10px 15px;
      border: 1px solid #ddd;
    }

    .detail-table .label {
      background: #f8f9fa;
      font-weight: 600;
      width: 200px;
    }

    .amount {
      font-size: 20px;
      font-weight: bold;
      color: #28a745;
    }

    .footer {
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
    }

    .signature-box {
      text-align: center;
      width: 200px;
    }

    .signature-line {
      border-bottom: 1px solid #333;
      height: 60px;
      margin-bottom: 5px;
    }

    .print-date {
      text-align: right;
      color: #666;
      font-size: 12px;
      margin-top: 30px;
    }

    @media print {
      body {
        padding: 0;
      }

      .no-print {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>ALDILA FINANCE</h1>
      <p>Sistem Keuangan Terpadu</p>
    </div>

    <div class="document-title">
      <h2>Bukti Pemasukan</h2>
      <span class="status-badge status-paid">LUNAS</span>
    </div>

    <table class="detail-table">
      <tr>
        <td class="label">No. Transaksi</td>
        <td><strong>{{ $pemasukan->nomor_transaksi }}</strong></td>
      </tr>
      <tr>
        <td class="label">Tanggal</td>
        <td>{{ $pemasukan->tanggal->format('d F Y') }}</td>
      </tr>
      <tr>
        <td class="label">Akun Pemasukan</td>
        <td>[{{ $pemasukan->akun->kode_akun }}] {{ $pemasukan->akun->nama_akun }}</td>
      </tr>
      <tr>
        <td class="label">Outlet</td>
        <td>{{ $pemasukan->outlet->nama }}</td>
      </tr>
      <tr>
        <td class="label">Jumlah</td>
        <td class="amount">Rp {{ number_format($pemasukan->jumlah, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="label">Peruntukan</td>
        <td>{{ $pemasukan->peruntukan->nama ?? '-' }}</td>
      </tr>
      <tr>
        <td class="label">Keterangan</td>
        <td>{{ $pemasukan->keterangan ?? '-' }}</td>
      </tr>
      <tr>
        <td class="label">Status</td>
        <td>Sudah Dicatat</td>
      </tr>
      <tr>
        <td class="label">Tanggal Tercatat</td>
        <td>{{ $pemasukan->paid_at ? $pemasukan->paid_at->format('d F Y H:i') : '-' }}</td>
      </tr>
    </table>

    <div class="footer">
      <div class="signature-box">
        <div class="signature-line"></div>
        <p>Disetujui Oleh</p>
      </div>
      <div class="signature-box">
        <div class="signature-line"></div>
        <p>Diterima Oleh</p>
      </div>
    </div>

    <div class="print-date">
      Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>

    <div class="no-print" style="margin-top: 30px; text-align: center;">
      <button onclick="window.print()"
        style="padding: 10px 20px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
        Cetak Dokumen
      </button>
      <button onclick="window.close()"
        style="padding: 10px 20px; background: #6c757d; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">
        Tutup
      </button>
    </div>
  </div>
</body>

</html>