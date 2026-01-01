<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
  protected string $title;

  public function __construct()
  {
    $this->title = 'Master Outlet';
  }

  public function index()
  {
    $outlets = Outlet::all();
    $title = $this->title;
    return view('outlet.index', compact('outlets', 'title'));
  }

  public function create()
  {
    $title = $this->title;
    return view('outlet.create', compact('title'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'alamat' => 'nullable|string',
      'telepon' => 'nullable|string|max:20',
    ]);

    Outlet::create($request->all());

    return redirect()->route('outlets.index')->with('success', 'Outlet created successfully.');
  }

  public function edit(Outlet $outlet)
  {
    $title = $this->title;
    return view('outlet.edit', compact('outlet', 'title'));
  }

  public function update(Request $request, Outlet $outlet)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'alamat' => 'nullable|string',
      'telepon' => 'nullable|string|max:20',
    ]);

    $outlet->update($request->all());

    return redirect()->route('outlets.index')->with('success', 'Outlet updated successfully.');
  }

  public function destroy(Outlet $outlet)
  {
    $outlet->delete();

    return redirect()->route('outlets.index')->with('success', 'Outlet deleted successfully.');
  }
}
