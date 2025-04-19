<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\BaseApi;
use App\Http\Requests\BrandRequest;
use App\Services\BrandSV;

class BrandController extends BaseApi {
    protected $brandSV;

    public function __construct() {
        $this->brandSV = new BrandSV();
    }

    public function getBrand($global_id) {
        try {
            $brand = $this->brandSV->getBrand($global_id);
            return $this->SuccessResponse($brand, 'Brand fetched successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function getAllBrands() {
        try {
            $brands = $this->brandSV->getAllBrands();
            return $this->SuccessResponse($brands, 'Brands fetched successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function createBrand(BrandRequest $request) {
        try {
            $params = [];
            $params = $request->only(['name']);
            $brand = $this->brandSV->createBrand($params);
            return $this->SuccessResponse($brand, 'Brand created successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function updateBrand(BrandRequest $request, $global_id) {
        try {
            $params = [];
            $params = $request->only(['name']);
            $brand = $this->brandSV->updateBrand($global_id, $params);
            return $this->SuccessResponse($brand, 'Brand updated successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function deleteBrand($global_id) {
        try {
            $brand = $this->brandSV->deleteBrand($global_id);
            return $this->SuccessResponse($brand, 'Brand deleted successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }
}