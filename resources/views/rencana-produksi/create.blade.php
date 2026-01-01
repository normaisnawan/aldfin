@extends('layouts.app')

@section('content')
  <div class="container-fluid p-4">
    <h4 class="mb-4">Buat Rencana Produksi</h4>

    <!-- INPUT SECTION -->
    <div class="card mb-4">
      <div class="card-header py-3 bg-white">
        <h6 class="m-0 fw-bold text-primary"><i data-lucide="pencil" class="w-4 h-4 me-2"></i>Buat Rencana Baru</h6>
      </div>
      <div class="card-body">
        <div class="row g-2">
          <!-- CUSTOMER SELECTION -->
          <div class="col-md-4">
            <label class="form-label">Customer (Untuk Siapa)</label>
            <select id="customerSelect" class="form-select">
              <option value="">-- Pilih Customer --</option>
              @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
              @endforeach
            </select>
          </div>

          <!-- MENU SELECTION -->
          <div class="col-md-4">
            <label class="form-label">Pilih Menu / Formula</label>
            <select id="menuSelect" class="form-select">
              <option value="">-- Pilih Formula --</option>
              @foreach ($formulas as $formula)
                <option value="{{ $formula->id }}">{{ $formula->nama }}</option>
              @endforeach
            </select>
          </div>

          <!-- PORSI & DATE -->
          <div class="col-md-2">
            <label class="form-label">Porsi</label>
            <input type="number" id="qtyPorsi" class="form-control px-2" value="100" min="1">
          </div>

          <div class="col-md-2">
            <label class="form-label">Tanggal</label>
            <input type="date" id="tglProduksi" class="form-control px-2" value="{{ date('Y-m-d') }}">
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12">
            <button class="btn btn-primary w-100" id="btnHitung">
              <i data-lucide="calculator" class="w-4 h-4 me-1"></i> Hitung Kebutuhan
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- RESULT SECTION (Hidden by default) -->
    <div class="card mb-4" id="resultCard" style="display:none;">
      <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
          <h6 class="m-0 fw-bold text-success"><i data-lucide="check-circle" class="w-4 h-4 me-2"></i>Kebutuhan Bahan Baku
          </h6>
        </div>
        <span id="labelSummary" class="badge bg-primary fs-6 fw-normal px-3 py-2"></span>
      </div>
      <div class="card-body p-0 table-responsive">
        <table class="table table-bordered mb-0 align-middle" id="calcTable">
          <thead>
            <tr>
              <th style="width: 40%">Nama Bahan</th>
              <th style="width: 20%" class="text-center">Qty/Porsi</th>
              <th style="width: 20%" class="text-center">Total Kebutuhan</th>
              <th style="width: 20%" class="text-center">Satuan</th>
            </tr>
          </thead>
          <tbody>
            <!-- Filled by JS -->
          </tbody>
        </table>
      </div>
      <div class="card-footer bg-white text-end py-3">
        <button class="btn btn-outline-secondary me-2"
          onclick="document.getElementById('resultCard').style.display='none'">Batal</button>
        <button class="btn btn-success" id="btnSimpanRencana">
          <i data-lucide="save" class="w-4 h-4 me-1"></i> Simpan Rencana Produksi
        </button>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    lucide.createIcons();

    let currentCalculation = null;

    document.getElementById('btnHitung').addEventListener('click', async () => {
      const menuId = document.getElementById('menuSelect').value;
      const customerId = document.getElementById('customerSelect').value;
      const customerName = document.getElementById('customerSelect').options[document.getElementById('customerSelect')
        .selectedIndex].text;
      const menuName = document.getElementById('menuSelect').options[document.getElementById('menuSelect')
        .selectedIndex].text;
      const porsi = parseInt(document.getElementById('qtyPorsi').value) || 0;
      const date = document.getElementById('tglProduksi').value;

      // Validation
      if (!menuId || !customerId || porsi <= 0 || !date) {
        Swal.fire('Error', 'Harap lengkapi semua form input (Customer, Menu, Porsi, Tanggal).', 'error');
        return;
      }

      try {
        // Fetch Formula Details via API
        const response = await fetch(`/api/formula/${menuId}`);
        const formula = await response.json();

        // Calculate Ingredients
        const calculatedIngredients = formula.items.map(item => {
          return {
            bahan_id: item.bahan.id,
            name: item.bahan.nama,
            qty_per_porsi: item.qty,
            total_qty: item.qty * porsi,
            unit: item.bahan.satuan.nama
          };
        });

        // Store temporary state
        currentCalculation = {
          formula_id: menuId,
          customer_id: customerId,
          porsi: porsi,
          tanggal: date,
          items: calculatedIngredients
        };

        // Render Result Table
        const tbody = document.querySelector('#calcTable tbody');
        tbody.innerHTML = '';

        calculatedIngredients.forEach((item) => {
          const row = `
                            <tr>
                                <td class="fw-bold">${item.name}</td>
                                <td class="text-center">${item.qty_per_porsi}</td>
                                <td class="text-center fw-bold text-primary">${item.total_qty.toLocaleString()}</td>
                                <td class="text-center text-muted">${item.unit}</td>
                            </tr>
                        `;
          tbody.innerHTML += row;
        });

        // Update UI Info
        document.getElementById('labelSummary').innerHTML = `${customerName} | ${menuName}`;

        // Show Card
        document.getElementById('resultCard').style.display = 'block';
        document.getElementById('resultCard').scrollIntoView({
          behavior: 'smooth'
        });

      } catch (error) {
        console.error(error);
        Swal.fire('Error', 'Gagal mengambil data formula.', 'error');
      }
    });

    document.getElementById('btnSimpanRencana').addEventListener('click', async () => {
      if (!currentCalculation) return;

      // Confirmation Popup
      const result = await Swal.fire({
        title: 'Konfirmasi Simpan',
        text: "Apakah Anda yakin ingin menyimpan rencana produksi ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal'
      });

      if (!result.isConfirmed) return;

      try {
        const response = await fetch('{{ route('rencana-produksi.store') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify(currentCalculation)
        });

        const result = await response.json();

        if (response.ok && result.success) {
          Swal.fire('Sukses', result.message, 'success').then(() => {
            window.location.href = '{{ route('rencana-produksi.index') }}';
          });
        } else {
          let errorMessage = result.message || 'Gagal menyimpan rencana produksi.';
          if (result.errors) {
            errorMessage += '\n' + Object.values(result.errors).flat().join('\n');
          }
          Swal.fire('Error', errorMessage, 'error');
        }
      } catch (error) {
        console.error(error);
        Swal.fire('Error', 'Terjadi kesalahan sistem: ' + error.message, 'error');
      }
    });
  </script>
@endsection