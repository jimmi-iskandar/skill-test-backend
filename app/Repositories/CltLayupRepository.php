<?php

namespace App\Repositories;

use App\Interfaces\CltLayupRepositoryInterface;
use App\Models\CltLayup;

class CltLayupRepository implements CltLayupRepositoryInterface {
    public function getLayupsBySupplier($supplierId) {
        return CltLayup::where('supplier_id', $supplierId)->get();
    }

    public function createLayup(array $data) {
        return CltLayup::create($data);
    }

    public function updateLayup($id, array $data) {
        $layup = CltLayup::findOrFail($id);
        $layup->update($data);
        return $layup;
    }

    public function deleteLayup($id) {
        return CltLayup::destroy($id);
        
    }
}