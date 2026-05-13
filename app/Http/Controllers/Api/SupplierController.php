<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\SupplierRepositoryInterface; 
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
   
    private $supplierRepo;

   
    public function __construct(SupplierRepositoryInterface $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    public function index()
    {
        return response()->json($this->supplierRepo->getAllSuppliers());
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        
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



    public function export($id)
    {
            
            $supplier = Supplier::with('layups.layers')->find($id);

            if (!$supplier) {
                return response()->json(['message' => 'Supplier not found'], 404);
            }

        $fileName = "export_supplier_{$supplier->id}.json";

        
        return response()->json($supplier, 200, [
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Content-Type' => 'application/json',
        ]);
    }

    public function import(Request $request, $supplierId)
{
    
    $request->validate([
        'file' => 'required|file|mimes:json,txt'
    ]);

    $supplier = Supplier::findOrFail($supplierId);

    $file = $request->file('file');
    

    if (!$file->isValid()) {
        return response()->json(['message' => 'File upload failed'], 400);
    }

    $data = json_decode(file_get_contents($file->getRealPath()), true);


    \DB::transaction(function () use ($data, $supplier) {
        foreach ($data['layups'] as $layupData) {
            $layup = $supplier->layups()->updateOrCreate(
                ['id' => $layupData['id'] ?? null],
                ['name' => $layupData['name']]
            );

            foreach ($layupData['layers'] as $layerData) {
                $layup->layers()->updateOrCreate(
                    ['id' => $layerData['id'] ?? null],
                    [
                        'layer_order' => $layerData['layer_order'],
                        'thickness'   => $layerData['thickness'],
                        'width'       => $layerData['width'],
                        'angle'       => $layerData['angle'],
                    ]
                );
            }
        }
    });

    return response()->json(['message' => 'Data imported successfully'], 200);
}
}