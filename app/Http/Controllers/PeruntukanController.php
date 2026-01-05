<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peruntukan;

class PeruntukanController extends Controller
{
  protected string $title;

  public function __construct()
  {
    $this->title = 'Master Peruntukan';
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $peruntukans = Peruntukan::all();
    $title = $this->title;
    return view('peruntukan.index', compact('peruntukans', 'title'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('peruntukan.create', [
      'title' => $this->title,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'deskripsi' => 'nullable|string',
    ]);

    Peruntukan::create($request->all());

    return redirect()->route('peruntukan.index')
      ->with('success', 'Peruntukan berhasil ditambahkan.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Peruntukan $peruntukan)
  {
    $title = $this->title;
    return view('peruntukan.show', compact('peruntukan', 'title'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Peruntukan $peruntukan)
  {
    $title = $this->title;
    return view('peruntukan.edit', compact('peruntukan', 'title'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Peruntukan $peruntukan)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'deskripsi' => 'nullable|string',
    ]);

    $peruntukan->update($request->all());

    return redirect()->route('peruntukan.index')
      ->with('success', 'Peruntukan berhasil diperbarui.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Peruntukan $peruntukan)
  {
    $peruntukan->delete();

    return redirect()->route('peruntukan.index')
      ->with('success', 'Peruntukan berhasil dihapus.');
  }
}
