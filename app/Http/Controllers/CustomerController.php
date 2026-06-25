<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::paginate(10);
        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Id_Cust' => 'required|unique:customers,Id_Cust|max:20',
            'Nama'    => 'required|max:100',
            'PIC'     => 'required|max:100',
        ]);

        Customer::create($request->only('Id_Cust', 'Nama', 'PIC'));

        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $customer = Customer::with(['purchaseOrders.invoices', 'purchaseOrders.suratJalan'])
            ->findOrFail($id);
        return view('customer.show', compact('customer'));
    }

    public function edit(string $hash)
    {
        $customer = Customer::findOrFail(decode_id($hash));
        return view('customer.form', compact('customer'));
    }

    public function update(Request $request, string $hash)
    {
        $request->validate([
            'Nama' => 'required|max:100',
            'PIC'  => 'required|max:100',
        ]);

        Customer::findOrFail(decode_id($hash))->update($request->only('Nama', 'PIC'));

        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $customer = Customer::withCount('purchaseOrders')->findOrFail($id);

        if ($customer->purchase_orders_count > 0) {
            return redirect()->route('customer.index')
                ->with('error', 'Customer tidak dapat dihapus karena memiliki Purchase Order.');
        }

        $customer->delete();

        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil dihapus.');
    }
}
