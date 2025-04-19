<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Api\v1\BaseApi;
use App\Services\ProductSV;

class ProductController extends BaseApi {
    protected $productSV;

    public function __construct() {
        $this->productSV = new ProductSV();
    }

    public function getProduct($global_id) {
        try {
            $product = $this->productSV->getProduct($global_id);
            return $this->SuccessResponse($product, 'Product fetched successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function getAllProducts() {
        try {
            $products = $this->productSV->getAllProducts();
            return $this->SuccessResponse($products, 'Products fetched successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }
}