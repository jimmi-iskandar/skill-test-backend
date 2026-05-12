<?php

namespace App\Interfaces;

interface CltLayerRepositoryInterface {
    public function getLayersByLayup($layupId);
    public function createLayer(array $data);
    public function updateLayer($id, array $data);
    public function deleteLayer($id);
}
