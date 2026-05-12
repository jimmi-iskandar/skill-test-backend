<?php

namespace App\Repositories;

use App\Interfaces\CltLayerRepositoryInterface;
use App\Models\CltLayer; 

class CltLayerRepository implements CltLayerRepositoryInterface {
    
    public function getLayersByLayup($layupId) {
        
        return CltLayer::where('layup_id', $layupId)->orderBy('layer_order', 'asc')->get();
    }

    public function createLayer(array $data) {
       
        return CltLayer::create($data);
    }

    public function updateLayer($id, array $data) {
        $layer = CltLayer::findOrFail($id);
        $layer->update($data);
        return $layer;
    }

    public function deleteLayer($id) {
        return CltLayer::destroy($id);
    }
}