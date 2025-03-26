<?php

namespace App\Services;

use App\Models\Product;

class ProductSV extends BaseService {
    public function getQuery() {
        return Product::query();
    }

    public function getProduct($global_id) {
        return $this->getByGlobalId($global_id);
    }

    public function getProductByID($id) {
        return $this->getByID($id);
    }

    public function getAllProducts($params = null) {
        return $this->getAll($params); // Use the getAll function from BaseService
    }

    public function createProduct($data) {    
        return $this->create($data);
    }

    public function updateProduct($global_id, $data) {
        return $this->update($data, $global_id);
    }

    public function deleteProduct($global_id) {
        return $this->softDelete($global_id);
    }

    // public function getProductsByCategory($category_id) {
    //     $query = $this->getQuery();
    //     $products = $query->where('category_id', $category_id)->get();
    //     return $products;
    // }
}