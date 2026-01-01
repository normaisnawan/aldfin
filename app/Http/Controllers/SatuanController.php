<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
  protected string $title;

  public function __construct()
  {
    $this->title = 'Master Satuan';
  }
  public function index()
  {
    $satuans = Satuan::all();
    $title = $this->title;
    return view('satuan.index', compact('satuans', 'title'));
  }

  public function create()
  {
    $title = $this->title;
    return view('satuan.create', compact('title'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
    ]);

    Satuan::create($request->all());

    return redirect()->route('satuan.index')->with('success', 'Satuan created successfully.');
  }

  public function edit(Satuan $satuan)
  {
    $title = $this->title;
    return view('satuan.edit', compact('satuan', 'title'));
  }

  public function update(Request $request, Satuan $satuan)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
    ]);

    $satuan->update($request->all());

    return redirect()->route('satuan.index')->with('success', 'Satuan updated successfully.');
  }

  public function destroy(Satuan $satuan)
  {
    $satuan->delete();

    return redirect()->route('satuan.index')->with('success', 'Satuan deleted successfully.');
  }
}
