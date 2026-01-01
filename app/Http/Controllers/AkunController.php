<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Akun;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected string $title;

    public function __construct()
    {
        $this->title = 'Master Akun';
    }
    public function index()
    {
        $akuns = Akun::all();
        $title = $this->title;
        return view('akun.index', compact('akuns', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('akun.create', [
            'title' => $this->title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_akun' => 'required|unique:akuns',
            'nama_akun' => 'required',
            'tipe_akun' => 'required',
        ]);

        Akun::create($request->all());

        return redirect()->route('akun.index')
            ->with('success', 'Akun created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Akun $akun)
    {
        $title = $this->title;
        return view('akun.show', compact('akun', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Akun $akun)
    {
        $title = $this->title;
        return view('akun.edit', compact('akun', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Akun $akun)
    {
        $request->validate([
            'kode_akun' => 'required|unique:akuns,kode_akun,' . $akun->id,
            'nama_akun' => 'required',
            'tipe_akun' => 'required',
        ]);

        $akun->update($request->all());

        return redirect()->route('akun.index')
            ->with('success', 'Akun updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Akun $akun)
    {
        $akun->delete();

        return redirect()->route('akun.index')
            ->with('success', 'Akun deleted successfully');
    }
}
