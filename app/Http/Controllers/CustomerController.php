<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  protected string $title;

  public function __construct()
  {
    $this->title = 'Master Customer';
  }
  public function index()
  {
    $title = $this->title;
    $customers = Customer::all();
    return view('customers.index', compact('customers', 'title'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $title = $this->title;
    return view('customers.create', compact('title'));
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

    Customer::create($request->all());

    return redirect()->route('customers.index')
      ->with('success', 'Customer created successfully.');
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Customer $customer)
  {
    $title = $this->title;
    return view('customers.edit', compact('customer', 'title'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Customer $customer)
  {
    $request->validate([
      'nama' => 'required',
      'email' => 'nullable|email',
      'no_hp' => 'nullable',
      'alamat' => 'nullable',
    ]);

    $customer->update($request->all());

    return redirect()->route('customers.index')
      ->with('success', 'Customer updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Customer $customer)
  {
    $customer->delete();

    return redirect()->route('customers.index')
      ->with('success', 'Customer deleted successfully');
  }
}
