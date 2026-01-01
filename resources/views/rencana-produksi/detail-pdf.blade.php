<!DOCTYPE html>
<html>

<head>
  <title>Detail Rencana Produksi</title>
  <style>
    body {
      font-family: sans-serif;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    .header {
      margin-bottom: 20px;
    }

    .info-table {
      width: 100%;
      margin-bottom: 20px;
      border: none;
    }

    .info-table td {
      border: none;
      padding: 5px;
    }
  </style>
</head>

<body>
  <div class="header">
    <h2 style="text-align: center;">Detail Rencana Produksi</h2>
  </div>

  <table class="info-table">
    <tr>
      <td width="150"><strong>ID Rencana</strong></td>
      <td>: {{ $plan->nomor_rencana ?? 'RP-' . str_pad($plan->id, 6, '0', STR_PAD_LEFT) }}</td>
    </tr>
    <tr>
      <td><strong>Tanggal</strong></td>
      <td>: {{ $plan->tanggal }}</td>
    </tr>
    <tr>
      <td><strong>Customer</strong></td>
      <td>: {{ $plan->customer->nama }}</td>
    </tr>
    <tr>
      <td><strong>Menu</strong></td>
      <td>: {{ $plan->formula->nama }}</td>
    </tr>
    <tr>
      <td><strong>Porsi</strong></td>
      <td>: {{ $plan->porsi }}</td>
    </tr>
  </table>

  <h3>Daftar Bahan Baku</h3>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Bahan</th>
        <th>Qty Per Porsi</th>
        <th>Total Qty</th>
        <th>Satuan</th>
      </tr>
    </thead>
    <tbody>
      @foreach($plan->items as $index => $item)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $item->bahan->nama }}</td>
          <td>{{ $item->qty_per_porsi }}</td>
          <td>{{ $item->total_qty }}</td>
          <td>{{ $item->bahan->satuan->nama }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>