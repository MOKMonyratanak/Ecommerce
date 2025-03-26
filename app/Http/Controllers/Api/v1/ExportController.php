<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\BaseApi;
use App\Http\Requests\ExportRequest;
use App\Services\ExportSV;
use App\Services\ProductSV;
use App\Services\UserSV;

class ExportController extends BaseApi {
    protected $exportSV;
    protected $productSV;
    protected $userSV;

    public function __construct() {
        $this->exportSV = new ExportSV();
        $this->productSV = new ProductSV();
        $this->userSV = new UserSV();
    }

    // Create a new export
    public function createExport(ExportRequest $request) {
        try {
            $params = [];
            $params = $request->only(['customer_id', 'product_id', 'quantity', 'price']);
            $customer = $this->userSV->getUserByID($params['customer_id']);
            if (!$customer) {
                return $this->ErrorResponse('Customer not found', 404);
            }
            $product = $this->productSV->getProductByID($params['product_id']);
            if (!$product) {
                return $this->ErrorResponse('Product not found', 404);
            }
            $export = $this->exportSV->createExport($params);
            return $this->SuccessResponse($export, 'Export created successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    // Get a single export by ID
    public function getExport($global_id) {
        try {
            $export = $this->exportSV->getExport($global_id);
            if (!$export) {
                return $this->ErrorResponse('Export not found', 404);
            }
            return $this->SuccessResponse($export, 'Export fetched successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    // Get all exports
    public function getAllExports() {
        try {
            $exports = $this->exportSV->getAllExports();
            return $this->SuccessResponse($exports, 'Exports fetched successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    // Update an export
    public function updateExport(ExportRequest $request, $global_id) {
        try {
            $params = [];
            $params = $request->only(['customer_id', 'product_id', 'quantity', 'price']);
            $customer = $this->userSV->getUserByID($params['customer_id']);
            if (!$customer) {
                return $this->ErrorResponse('Customer not found', 404);
            }
            $product = $this->productSV->getProductByID($params['product_id']);
            if (!$product) {
                return $this->ErrorResponse('Product not found', 404);
            }
            
            $export = $this->exportSV->updateExport($global_id, $params);
            return $this->SuccessResponse($export, 'Export updated successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    // Delete an export (soft delete)
    public function deleteExport($global_id) {
        try {
            $export = $this->exportSV->deleteExport($global_id);
            return $this->SuccessResponse($export, 'Export deleted successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function markExportAsShipped($global_id) {
        try {
            $export = $this->exportSV->markShipped($global_id);
            return $this->SuccessResponse($export, 'Export marked as shipped successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 400);
        }
    }

    public function markExportAsCanceled($global_id) {
        try {
            $export = $this->exportSV->markCanceled($global_id);
            return $this->SuccessResponse($export, 'Export marked as canceled successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 400);
        }
    }

    public function markExportAsPending($global_id) {
        try {
            $export = $this->exportSV->markPending($global_id);
            return $this->SuccessResponse($export, 'Export marked as pending successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 400);
        }
    }
}