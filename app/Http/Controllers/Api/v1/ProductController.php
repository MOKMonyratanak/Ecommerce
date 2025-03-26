<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseApi;
use App\Http\Requests\ProductRequest;
use App\Services\ProductSV;
use App\Services\CategorySV;

class ProductController extends BaseApi {
    protected $productSV;
    protected $categorySV;

    public function __construct() {
        $this->productSV = new ProductSV();
        $this->categorySV = new CategorySV();
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

    public function createProduct(ProductRequest $request) {
        try {
            $params = [];
            $params = $request->only(['name', 'price', 'category_id', 'quantity', 'description']);
            $category = $this->categorySV->getCategoryByID($params['category_id']);
            if (!$category) {
                return $this->ErrorResponse('Category not found', 404);
            }
            $product = $this->productSV->createProduct($params);
            return $this->SuccessResponse($product, 'Product created successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function updateProduct(ProductRequest $request, $global_id) {
        try {
            $params = [];
            $params = $request->only(['name', 'price', 'category_id', 'quantity', 'description']);
            $category = $this->categorySV->getCategoryByID($params['category_id']);
            if (!$category) {
                return $this->ErrorResponse('Category not found', 404);
            }
            $product = $this->productSV->updateProduct($global_id, $params);
            return $this->SuccessResponse($product, 'Product updated successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function deleteProduct($global_id) {
        try {
            $product = $this->productSV->deleteProduct($global_id);
            return $this->SuccessResponse($product, 'Product deleted successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }
}