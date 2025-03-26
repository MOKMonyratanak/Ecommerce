<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseApi;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Services\SupplierSV;

class SupplierController extends BaseApi {
    protected $supplierSV;

    public function __construct() {
        $this->supplierSV = new SupplierSV();
    }

    public function getSupplier($global_id) {
        try {
            $supplier = $this->supplierSV->getSupplier($global_id);
            return $this->SuccessResponse($supplier, 'Supplier fetched successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function getAllSuppliers() {
        try {
            $suppliers = $this->supplierSV->getAllSuppliers();
            return $this->SuccessResponse($suppliers, 'Suppliers fetched successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function createSupplier(StoreSupplierRequest $request) {
        try {
            $params = [];
            $params = $request->only(['name', 'phone_number', 'email', 'address']);
            $supplier = $this->supplierSV->createSupplier($params);
            return $this->SuccessResponse($supplier, 'Supplier created successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function updateSupplier(UpdateSupplierRequest $request, $id) {
        try {
            $params = [];
            $params = $request->only(['name', 'phone_number', 'email', 'address']);
            $supplier = $this->supplierSV->updateSupplier($id, $params);
            return $this->SuccessResponse($supplier, 'Supplier updated successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function deleteSupplier($id) {
        try {
            $supplier = $this->supplierSV->deleteSupplier($id);
            return $this->SuccessResponse($supplier, 'Supplier deleted successfully');
        }
        catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }
}
