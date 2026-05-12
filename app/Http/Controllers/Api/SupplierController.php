<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\SupplierRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupplierController extends Controller
{
    private SupplierRepositoryInterface $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository) 
    {
        // Dependency Injection
        $this->supplierRepository = $supplierRepository;
    }

    public function index()
    {
        $suppliers = $this->supplierRepository->getAllSuppliers();
        return response()->json(['data' => $suppliers]);
    }

    public function store(Request $request)
    {
        
        // Validasi dasar
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $supplier = $this->supplierRepository->createSupplier($validated);

        return response()->json(['data' => $supplier], Response::HTTP_CREATED);
        //menampilkan isi 
        return response()->json($request->all());
    }

    public function show($id)
    {
        $supplier = $this->supplierRepository->getSupplierById($id);
        return response()->json(['data' => $supplier]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $this->supplierRepository->updateSupplier($id, $validated);
        $updatedSupplier = $this->supplierRepository->getSupplierById($id);

        return response()->json(['data' => $updatedSupplier]);
    }
    

    public function destroy($id)
    {
        $this->supplierRepository->deleteSupplier($id);
        return response()->json([
        'message' => 'Supplier deleted successfully!'
    ], 200);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}