<?php

namespace App\Repositories;

use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;

class SupplierRepository implements SupplierRepositoryInterface {
    public function getAllSuppliers() {
        return Supplier::all();
    }

    public function getSupplierById($supplierId) {
        return Supplier::findOrFail($supplierId);
    }

    public function createSupplier(array $supplierDetails) {
        return Supplier::create($supplierDetails);
    }

    public function updateSupplier($supplierId, array $newDetails) {
        return Supplier::whereId($supplierId)->update($newDetails);
    }

    public function deleteSupplier($supplierId) {
        Supplier::destroy($supplierId);
    }
}
