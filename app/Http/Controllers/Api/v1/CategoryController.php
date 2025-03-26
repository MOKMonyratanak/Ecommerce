<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseApi;
use App\Http\Requests\CategoryRequest;
use App\Services\CategorySV;

class CategoryController extends BaseApi {
    protected $categorySV;

    public function __construct() {
        $this->categorySV = new CategorySV();
    }

    public function getCategory($global_id) {
        try {
            $category = $this->categorySV->getCategory($global_id);
            return $this->SuccessResponse($category, 'Category fetched successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function getAllCategories() {
        try {
            $categories = $this->categorySV->getAllCategories();
            return $this->SuccessResponse($categories, 'Categories fetched successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function createCategory(CategoryRequest $request) {
        try {
            $params = [];
            $params = $request->only(['name']);
            $category = $this->categorySV->createCategory($params);
            return $this->SuccessResponse($category, 'Category created successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function updateCategory(CategoryRequest $request, $global_id) {
        try {
            $params = [];
            $params = $request->only(['name']);
            $category = $this->categorySV->updateCategory($global_id, $params);
            return $this->SuccessResponse($category, 'Category updated successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function deleteCategory($global_id) {
        try {
            $category = $this->categorySV->deleteCategory($global_id);
            return $this->SuccessResponse($category, 'Category deleted successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }
}