<?php

namespace App\Services;

use App\Models\Category;

class CategorySV extends BaseService {
    public function getQuery() {
        return Category::query();
    }

    public function getCategory($global_id) {
        return $this->getByGlobalId($global_id);
    }

    public function getCategoryByID($id) {
        return $this->getByID($id);
    }

    public function getAllCategories($params = null) {
        return $this->getAll($params); // Use the getAll function from BaseService
    }

    public function createCategory($data) {
    return $this->create($data);
    }

    public function updateCategory($global_id, $data) {
        return $this->update($data, $global_id);
    }

    public function deleteCategory($global_id) {
        return $this->softDelete($global_id);
    }

    
}