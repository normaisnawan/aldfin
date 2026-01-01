<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BahanController extends Controller
{
  protected string $title;

  public function __construct()
  {
    $this->title = 'Master Bahan Baku';
  }
  public function index()
  {
    $bahans = Bahan::with('satuan')->get();
    $title = $this->title;
    return view('bahan.index', compact('bahans', 'title'));
  }

  public function create()
  {
    $title = $this->title;
    $satuans = Satuan::all();
    return view('bahan.create', compact('satuans', 'title'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'satuan_id' => 'required|exists:satuans,id',
    ]);

    Bahan::create($request->all());

    return redirect()->route('bahan.index')->with('success', 'Bahan created successfully.');
  }

  public function edit(Bahan $bahan)
  {
    $title = $this->title;
    $satuans = Satuan::all();
    return view('bahan.edit', compact('bahan', 'satuans', 'title'));
  }

  public function update(Request $request, Bahan $bahan)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'satuan_id' => 'required|exists:satuans,id',
    ]);

    $bahan->update($request->all());

    return redirect()->route('bahan.index')->with('success', 'Bahan updated successfully.');
  }

  public function destroy(Bahan $bahan)
  {
    $bahan->delete();

    return redirect()->route('bahan.index')->with('success', 'Bahan deleted successfully.');
  }
}
