<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\SupplierRepositoryInterface; // Pastikan ini di-import
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // 1. Kamu HARUS mendefinisikan variabel ini
    private $supplierRepo;

    // 2. Kamu HARUS memasukkannya ke Constructor (Dependency Injection)
    public function __construct(SupplierRepositoryInterface $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    public function index()
    {
        return response()->json($this->supplierRepo->getAllSuppliers());
    }

    // 3. Pastikan fungsi store HANYA menerima Request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // Sekarang $this->supplierRepo tidak akan "Undefined" lagi
        $supplier = $this->supplierRepo->createSupplier($validated);

        return response()->json($supplier, 201);
    }

    public function show($id)
    {
        return response()->json($this->supplierRepo->getSupplierById($id));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate(['name' => 'required|string']);
        return response()->json($this->supplierRepo->updateSupplier($id, $validated));
    }

    public function destroy($id)
    {
        $this->supplierRepo->deleteSupplier($id);
        return response()->json(['message' => 'Supplier deleted']);
    }
}