<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\BaseApi;
use App\Http\Requests\ImportRequest;
use App\Services\ImportSV;
use App\Services\ProductSV;
use App\Services\SupplierSV;

class ImportController extends BaseApi {
    protected $importSV;
    protected $productSV;
    protected $supplierSV;

    public function __construct() {
        $this->importSV = new ImportSV();
        $this->productSV = new ProductSV();
        $this->supplierSV = new SupplierSV();
    }

    // Create a new import
    public function createImport(ImportRequest $request) {
        try {
            $params = [];
            $params = $request->only(['supplier_id', 'product_id', 'quantity', 'price']);
            $supplier = $this->supplierSV->getSupplierByID($params['supplier_id']);
            if (!$supplier) {
                return $this->ErrorResponse('Supplier not found', 404);
            }
            $product = $this->productSV->getProductByID($params['product_id']);
            if (!$product) {
                return $this->ErrorResponse('Product not found', 404);
            }
            $import = $this->importSV->createImport($params);
            return $this->SuccessResponse($import, 'Import created successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    // Get a single import by ID
    public function getImport($global_id) {
        try {
            $import = $this->importSV->getImport($global_id);
            if (!$import) {
                return $this->ErrorResponse('Import not found', 404);
            }
            return $this->SuccessResponse($import, 'Import fetched successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    // Get all imports
    public function getAllImports() {
        try {
            $imports = $this->importSV->getAllImports();
            return $this->SuccessResponse($imports, 'Imports fetched successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    // Update an import
    public function updateImport(ImportRequest $request, $global_id) {
        try {
            $params = [];
            $params = $request->only(['supplier_id', 'product_id', 'quantity', 'price']);
            $supplier = $this->supplierSV->getSupplierByID($params['supplier_id']);
            if (!$supplier) {
                return $this->ErrorResponse('Supplier not found', 404);
            }
            $product = $this->productSV->getProductByID($params['product_id']);
            if (!$product) {
                return $this->ErrorResponse('Product not found', 404);
            }
            
            $import = $this->importSV->updateImport($global_id, $params);
            return $this->SuccessResponse($import, 'Import updated successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    // Delete an import (soft delete)
    public function deleteImport($global_id) {
        try {
            $import = $this->importSV->deleteImport($global_id);
            return $this->SuccessResponse($import, 'Import deleted successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function markImportAsReceived($global_id) {
        try {
            $import = $this->importSV->markReceived($global_id);
            return $this->SuccessResponse($import, 'Import marked as received successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 400);
        }
    }

    public function markImportAsCanceled($global_id) {
        try {
            $import = $this->importSV->markCanceled($global_id);
            return $this->SuccessResponse($import, 'Import marked as canceled successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 400);
        }
    }

    public function markImportAsPending($global_id) {
        try {
            $import = $this->importSV->markPending($global_id);
            return $this->SuccessResponse($import, 'Import marked as pending successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 400);
        }
    }
}