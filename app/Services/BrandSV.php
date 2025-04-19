<?php

namespace App\Services;

use App\Models\Brand;

class BrandSV extends BaseService {
    public function getQuery() {
        return Brand::query();
    }

    public function getBrand($global_id) {
        return $this->getByGlobalId($global_id);
    }

    public function getBrandByID($id) {
        return $this->getByID($id);
    }

    public function getAllBrands($params = null) {
        return $this->getAll($params); // Use the getAll function from BaseService
    }

    public function createBrand($data) {
    return $this->create($data);
    }

    public function updateBrand($global_id, $data) {
        return $this->update($data, $global_id);
    }

    public function deleteBrand($global_id) {
        return $this->softDelete($global_id);
    }

    
}