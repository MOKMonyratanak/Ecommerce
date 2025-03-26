<?php

namespace App\Services;

use App\Models\Supplier;

class SupplierSV extends BaseService {
    public function getQuery() {
        return Supplier::query();
    }

    public function getSupplier($global_id) {
        return $this->getByGlobalId($global_id);
    }

    public function getSupplierByID($id) {
        return $this->getByID($id);
    }

    public function getAllSuppliers($params = null) {
        return $this->getAll($params); // Use the getAll function from BaseService
    }

    public function createSupplier($data) {
        return $this->create($data);
    }

    public function updateSupplier($global_id, $data) {
        return $this->update($data, $global_id);
    }

    public function deleteSupplier($global_id) {
        return $this->softDelete($global_id);
    }
}