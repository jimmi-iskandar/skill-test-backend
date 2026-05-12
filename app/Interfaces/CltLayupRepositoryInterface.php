<?php

namespace App\Interfaces;

interface CltLayupRepositoryInterface {
    public function getLayupsBySupplier($supplierId);
    public function createLayup(array $data);
    public function updateLayup($id, array $data);
    public function deleteLayup($id);
}