<?php

namespace App\Http\Controllers\Api;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\SupplierCollection;

class BankSuppliersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Bank $bank)
    {
        $this->authorize('view', $bank);

        $search = $request->get('search', '');

        $suppliers = $bank
            ->suppliers()
            ->search($search)
            ->latest()
            ->paginate();

        return new SupplierCollection($suppliers);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Bank $bank)
    {
        $this->authorize('create', Supplier::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'no_telp' => ['nullable', 'string'],
            'address' => ['nullable', 'max:255', 'string'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'regency_id' => ['nullable', 'exists:regencies,id'],
            'village_id' => ['nullable', 'exists:villages,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
            'codepos' => ['nullable', 'numeric', 'digits:5'],
            'bank_account_name' => ['nullable', 'max:255', 'string'],
            'bank_account_no' => ['nullable', 'string', 'numeric'],
            'status' => ['required', 'in:1,2,3,4'],
            'image' => ['image', 'nullable'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $supplier = $bank->suppliers()->create($validated);

        return new SupplierResource($supplier);
    }
}
