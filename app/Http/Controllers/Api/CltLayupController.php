<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\CltLayupRepositoryInterface;
use Illuminate\Http\Request;

class CltLayupController extends Controller {
    private $layupRepo;

    public function __construct(CltLayupRepositoryInterface $layupRepo) {
        $this->layupRepo = $layupRepo;
    }

    // GET /api/suppliers/{supplierId}/layups
    public function index($supplierId) {
        $layups = $this->layupRepo->getLayupsBySupplier($supplierId);
        return response()->json($layups);
    }

    // POST /api/suppliers/{supplierId}/layups
    public function store(Request $request, $supplierId) {
        $validated = $request->validate(['name' => 'required|string|max:255']);
        $validated['supplier_id'] = $supplierId;

        $layup = $this->layupRepo->createLayup($validated);
        return response()->json($layup, 201);
    }

    // PUT /api/suppliers/{supplierId}/layups/{id}
    public function update(Request $request, $supplierId, $id) {
        $validated = $request->validate(['name' => 'required|string|max:255']);
        
        // Validasi: Pastikan Layup ini milik Supplier tersebut
        $check = \App\Models\CltLayup::where('id', $id)->where('supplier_id', $supplierId)->firstOrFail();
        
        $layup = $this->layupRepo->updateLayup($id, $validated);
        return response()->json($layup);
    }

    // DELETE /api/suppliers/{supplierId}/layups/{id}
    public function destroy($supplierId, $id) {
        $check = \App\Models\CltLayup::where('id', $id)->where('supplier_id', $supplierId)->firstOrFail();
        
        $this->layupRepo->deleteLayup($id);
        return response()->json(['message' => 'Layup deleted successfully']);
    }
}