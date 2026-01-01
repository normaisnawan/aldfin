<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  protected string $title;

  public function __construct()
  {
    $this->title = 'Master Vendor';
  }
  public function index()
  {
    $title = $this->title;
    $vendors = Vendor::all();
    return view('vendors.index', compact('vendors', 'title'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $title = $this->title;
    return view('vendors.create', compact('title'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required',
      'email' => 'nullable|email',
      'no_hp' => 'nullable',
      'alamat' => 'nullable',
    ]);

    Vendor::create($request->all());

    return redirect()->route('vendors.index')
      ->with('success', 'Vendor created successfully.');
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Vendor $vendor)
  {
    $title = $this->title;
    return view('vendors.edit', compact('vendor', 'title'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Vendor $vendor)
  {
    $request->validate([
      'nama' => 'required',
      'email' => 'nullable|email',
      'no_hp' => 'nullable',
      'alamat' => 'nullable',
    ]);

    $vendor->update($request->all());

    return redirect()->route('vendors.index')
      ->with('success', 'Vendor updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Vendor $vendor)
  {
    $vendor->delete();

    return redirect()->route('vendors.index')
      ->with('success', 'Vendor deleted successfully');
  }
}
