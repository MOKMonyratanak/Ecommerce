<?php

namespace App\Http\Controllers\Api\v1\User;

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
            $params = $request->only(['product_id', 'quantity']);
    
            // Set the authenticated user's ID as the customer_id
            $params['customer_id'] = auth()->user()->id;
            // Validate product existence and calculate price
            $product = $this->productSV->getProductByID($params['product_id']);
            if (!$product) {
                return $this->ErrorResponse('Product not found', 404);
            }
            $params['price'] = $product->price * $params['quantity']; // Calculate price
    
            // Create export
            $export = $this->exportSV->createExport($params);
            return $this->SuccessResponse($export, 'Export created successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    // Get a single export by ID
    public function getExport($global_id) {
        try {
            // Fetch the export by global ID
            $export = $this->exportSV->getExport($global_id);
            if (!$export) {
                return $this->ErrorResponse('Export not found', 404);
            }
    
            // Check if the authenticated user is the owner of the export
            if ($export->customer_id !== auth()->user()->id) {
                return $this->ErrorResponse('You are not authorized to view this export', 403);
            }
    
            return $this->SuccessResponse($export, 'Export fetched successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    // Get all exports
    public function getAllExports() {
        try {
            // Fetch all exports for the authenticated user
            $customer_id = auth()->user()->id;
            $exports = $this->exportSV->getExportsByCustomerId($customer_id);
    
            return $this->SuccessResponse($exports, 'Exports fetched successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 500);
        }
    }

    public function markExportAsCanceled($global_id) {
        try {
            // Fetch the export by ID
            $export = $this->exportSV->getExport($global_id);
            if (!$export) {
                return $this->ErrorResponse('Export not found', 404);
            }
    
            // Check if the status is "pending"
            if ($export->status !== 'pending') {
                return $this->ErrorResponse('Only pending exports can be canceled', 400);
            }
    
            // Mark the export as canceled
            $export = $this->exportSV->markCanceled($global_id);
            return $this->SuccessResponse($export, 'Export marked as canceled successfully');
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), 400);
        }
    }
}