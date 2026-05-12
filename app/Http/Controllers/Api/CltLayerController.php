<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\CltLayerRepositoryInterface;
use App\Models\CltLayup;
use Illuminate\Http\Request;

class CltLayerController extends Controller {
    private $layerRepo;

    public function __construct(CltLayerRepositoryInterface $layerRepo) {
        $this->layerRepo = $layerRepo;
    }

    // GET /api/suppliers/{supplierId}/layups/{layupId}/layers
    public function index($supplierId, $layupId) {
        // Validasi hirarki
        \App\Models\CltLayup::where('id', $layupId)->where('supplier_id', $supplierId)->firstOrFail();
        
        return response()->json($this->layerRepo->getLayersByLayup($layupId));
    }

    // POST /api/suppliers/{supplierId}/layups/{layupId}/layers
    public function store(Request $request, $supplierId, $layupId) {
        \App\Models\CltLayup::where('id', $layupId)->where('supplier_id', $supplierId)->firstOrFail();

        $validated = $request->validate([
            'layer_order' => 'required|integer',
            'thickness'   => 'required|numeric',
            'width'       => 'required|numeric',
            'angle'       => 'required|numeric',
        ]);

        $validated['layup_id'] = $layupId;
        $layer = $this->layerRepo->createLayer($validated);
        return response()->json($layer, 201);
    }

    // DELETE /api/suppliers/{supplierId}/layups/{layupId}/layers/{id}
    public function destroy($supplierId, $layupId, $id) {
        // Validasi hirarki super ketat
        $layer = \App\Models\CltLayer::where('id', $id)
            ->where('layup_id', $layupId)
            ->whereHas('layup', function($q) use ($supplierId) {
                $q->where('supplier_id', $supplierId);
            })->firstOrFail();

        $this->layerRepo->deleteLayer($id);
        return response()->json(['message' => 'Layer deleted successfully']);
    }
}