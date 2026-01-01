<!DOCTYPE html>
<html>

<head>
  <title>Laporan Rencana Produksi</title>
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
      text-align: center;
      margin-bottom: 20px;
    }

    .badge {
      padding: 2px 5px;
      border-radius: 3px;
      color: white;
      font-size: 10px;
    }

    .bg-success {
      background-color: #198754;
    }

    .bg-secondary {
      background-color: #6c757d;
    }
  </style>
</head>

<body>
  <div class="header">
    <h2>Laporan Rencana Produksi</h2>
    <p>Dicetak pada: {{ date('d-m-Y H:i') }}</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>ID Rencana</th>
        <th>Tanggal</th>
        <th>Customer</th>
        <th>Menu</th>
        <th>Porsi</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($plans as $index => $plan)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $plan->nomor_rencana ?? 'RP-' . str_pad($plan->id, 6, '0', STR_PAD_LEFT) }}</td>
          <td>{{ $plan->tanggal }}</td>
          <td>{{ $plan->customer->nama }}</td>
          <td>{{ $plan->formula->nama }}</td>
          <td>{{ $plan->porsi }}</td>
          <td>{{ $plan->status }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>