<?php

namespace App\Http\Controllers;

use App\Models\ProductionPlan;
use App\Models\ProductionPlanItem;
use App\Models\Customer;
use App\Models\Formula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionPlanController extends Controller
{
  protected string $title;

  public function __construct()
  {
    $this->title = 'Rencana Produksi';
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $title = $this->title;
    $plans = ProductionPlan::with(['customer', 'formula'])->orderBy('created_at', 'desc')->get();
    return view('rencana-produksi.index', compact('plans', 'title'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $title = $this->title;
    $customers = Customer::all();
    $formulas = Formula::all();
    return view('rencana-produksi.create', compact('customers', 'formulas', 'title'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'customer_id' => 'required|exists:customers,id',
      'formula_id' => 'required|exists:formulas,id',
      'tanggal' => 'required|date',
      'porsi' => 'required|integer|min:1',
      'items' => 'required|array',
      'items.*.bahan_id' => 'required|exists:bahans,id',
      'items.*.qty_per_porsi' => 'required|numeric',
      'items.*.total_qty' => 'required|numeric',
    ]);

    DB::transaction(function () use ($request) {
      // Generate Nomor Rencana: RP-MMYYXXXX
      $monthYear = date('my'); // e.g., 0125
      $prefix = 'RP-' . $monthYear;

      // Find the last plan with this prefix
      $lastPlan = ProductionPlan::where('nomor_rencana', 'like', $prefix . '%')
        ->orderBy('nomor_rencana', 'desc')
        ->first();

      if ($lastPlan) {
        // Extract the last 4 digits
        $lastNumber = intval(substr($lastPlan->nomor_rencana, -4));
        $newNumber = $lastNumber + 1;
      } else {
        $newNumber = 1;
      }

      $nomorRencana = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

      $plan = ProductionPlan::create([
        'nomor_rencana' => $nomorRencana,
        'customer_id' => $request->customer_id,
        'formula_id' => $request->formula_id,
        'tanggal' => $request->tanggal,
        'porsi' => $request->porsi,
        'status' => 'Planned',
      ]);

      foreach ($request->items as $item) {
        $plan->items()->create([
          'bahan_id' => $item['bahan_id'],
          'qty_per_porsi' => $item['qty_per_porsi'],
          'total_qty' => $item['total_qty'],
        ]);
      }
    });

    return response()->json(['success' => true, 'message' => 'Rencana Produksi Berhasil Disimpan!']);
  }

  /**
   * Display the specified resource.
   */
  public function show(ProductionPlan $productionPlan)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(ProductionPlan $rencana_produksi)
  {
    $title = $this->title;
    $customers = Customer::all();
    $formulas = Formula::all();
    $rencana_produksi->load(['items.bahan.satuan', 'formula', 'customer']);
    return view('rencana-produksi.edit', compact('rencana_produksi', 'customers', 'formulas', 'title'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, ProductionPlan $rencana_produksi)
  {
    $request->validate([
      'customer_id' => 'required|exists:customers,id',
      'formula_id' => 'required|exists:formulas,id',
      'tanggal' => 'required|date',
      'porsi' => 'required|integer|min:1',
      'items' => 'required|array',
      'items.*.bahan_id' => 'required|exists:bahans,id',
      'items.*.qty_per_porsi' => 'required|numeric',
      'items.*.total_qty' => 'required|numeric',
    ]);

    DB::transaction(function () use ($request, $rencana_produksi) {
      $rencana_produksi->update([
        'customer_id' => $request->customer_id,
        'formula_id' => $request->formula_id,
        'tanggal' => $request->tanggal,
        'porsi' => $request->porsi,
      ]);

      // Delete existing items and recreate
      $rencana_produksi->items()->delete();

      foreach ($request->items as $item) {
        $rencana_produksi->items()->create([
          'bahan_id' => $item['bahan_id'],
          'qty_per_porsi' => $item['qty_per_porsi'],
          'total_qty' => $item['total_qty'],
        ]);
      }
    });

    return response()->json(['success' => true, 'message' => 'Rencana Produksi Berhasil Diupdate!']);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(ProductionPlan $rencana_produksi)
  {
    $rencana_produksi->delete();
    return redirect()->route('rencana-produksi.index')->with('success', 'Rencana Produksi berhasil dihapus.');
  }

  public function getFormulaDetails(Formula $formula)
  {
    $formula->load('items.bahan.satuan');
    return response()->json($formula);
  }

  public function exportPdf()
  {
    $plans = ProductionPlan::with(['customer', 'formula'])->orderBy('created_at', 'desc')->get();
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('rencana-produksi.pdf', compact('plans'));
    return $pdf->download('laporan-rencana-produksi.pdf');
  }

  public function exportExcel()
  {
    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ProductionPlanExport, 'laporan-rencana-produksi.xlsx');
  }

  public function exportDetailPdf(ProductionPlan $plan)
  {
    $plan->load(['items.bahan.satuan', 'customer', 'formula']);
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('rencana-produksi.detail-pdf', compact('plan'));
    return $pdf->download('detail-rencana-' . ($plan->nomor_rencana ?? $plan->id) . '.pdf');
  }

  public function exportDetailExcel(ProductionPlan $plan)
  {
    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ProductionPlanDetailExport($plan->id), 'detail-rencana-' . ($plan->nomor_rencana ?? $plan->id) . '.xlsx');
  }
}
