<?php

namespace App\Http\Controllers;

use App\Models\Formula;
use App\Models\FormulaItem;
use App\Models\Bahan;
use Illuminate\Http\Request;

class FormulaController extends Controller
{
  protected string $title;

  public function __construct()
  {
    $this->title = 'Master Formula';
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $title = $this->title;
    $formulas = Formula::with('items.bahan')->get();
    return view('formula.index', compact('formulas', 'title'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $title = $this->title;
    return view('formula.create', compact('title'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required',
      'deskripsi' => 'nullable',
    ]);

    $formula = Formula::create([
      'nama' => $request->nama,
      'deskripsi' => $request->deskripsi,
    ]);

    return redirect()->route('formula.edit', $formula->id)
      ->with('success', 'Formula created successfully. Please add ingredients.');
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Formula $formula)
  {
    $title = $this->title;
    $bahans = Bahan::all();
    $formula->load('items.bahan');
    return view('formula.edit', compact('formula', 'bahans', 'title'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Formula $formula)
  {
    $request->validate([
      'nama' => 'required',
      'deskripsi' => 'nullable',
    ]);

    $formula->update([
      'nama' => $request->nama,
      'deskripsi' => $request->deskripsi,
    ]);

    return redirect()->route('formula.index')
      ->with('success', 'Formula updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Formula $formula)
  {
    $formula->delete();

    return redirect()->route('formula.index')
      ->with('success', 'Formula deleted successfully');
  }

  public function storeItem(Request $request, Formula $formula)
  {
    $request->validate([
      'bahan_id' => 'required|exists:bahans,id',
      'qty' => 'required|numeric|min:0',
    ]);

    $formula->items()->create([
      'bahan_id' => $request->bahan_id,
      'qty' => $request->qty,
    ]);

    return redirect()->back()->with('success', 'Ingredient added successfully');
  }

  public function destroyItem(FormulaItem $formulaItem)
  {
    $formulaItem->delete();
    return redirect()->back()->with('success', 'Ingredient removed successfully');
  }
}
