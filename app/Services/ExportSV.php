<?php

namespace App\Services;

use App\Models\Export;
use App\Models\Product;

class ExportSV extends BaseService {
    public function getQuery() {
        return Export::query();
    }

    public function getExport($global_id) {
        return $this->getByGlobalId($global_id);
    }

    // public function getExportByID($id) {
    //     return $this->getByID($id);
    // }

    public function getAllExports($params = null) {
        return $this->getAll($params); // Use the getAll function from BaseService
    }

    public function getExportsByCustomerId($customer_id) {
        return Export::where('customer_id', $customer_id)->get();
    }

    public function createExport($data) {
        // Fetch the product by its ID
        $product = Product::where('id', $data['product_id'])->first(); // Ensure 'product_id' exists in the $data
        if (!$product) {
            throw new \Exception("Product with ID {$data['product_id']} not found.");
        }
    
        // Check if the product has enough quantity
        if ($product->quantity < $data['quantity']) {
            throw new \Exception("Insufficient product quantity for export. Available: {$product->quantity}, Requested: {$data['quantity']}.");
        }
    
        // Reduce the product quantity
        $product->quantity -= $data['quantity'];
        $product->save();
    
        // Create the export record
        return $this->create($data);
    }

    public function updateExport($global_id, $data) {
        return $this->update($data, $global_id);
    }

    public function deleteExport($global_id) {
        return $this->softDelete($global_id);
    }

    public function markShipped($global_id) {
        // Fetch the export record by global_id
        $export = $this->getByGlobalId($global_id);
    
        if (!$export) {
            throw new \Exception("Export with ID {$global_id} not found.");
        }
    
        // Check if the status is already "shipped"
        if ($export->status === 'shipped') {
            throw new \Exception("Export is already marked as shipped.");
        }
    
        // Fetch the associated product
        $product = Product::where('id', $export->product_id)->first(); // Fetch the product by its ID
        if (!$product) {
            throw new \Exception("Product with ID {$export->product_id} not found.");
        }
    
        // Handle status transitions
        if ($export->status === 'canceled') {
            // If the status is "canceled", reduce the product quantity
            if ($product->quantity < $export->quantity) {
                throw new \Exception("Insufficient product quantity for export. Available: {$product->quantity}, Requested: {$export->quantity}.");
            }
            $product->quantity -= $export->quantity; // Reduce the product quantity
            $product->save();
        }
    
        // Update the export status to "shipped"
        $export->status = 'shipped';
        $export->save();
    
        return $export;
    }

    public function markCanceled($global_id) {
        // Fetch the export record by global_id
        $export = $this->getByGlobalId($global_id);
    
        if (!$export) {
            throw new \Exception("Export with ID {$global_id} not found.");
        }
    
        // Check if the status is already "canceled"
        if ($export->status === 'canceled') {
            throw new \Exception("Export is already marked as canceled.");
        }
    
        // Fetch the associated product
        $product = Product::where('id', $export->product_id)->first(); // Fetch the product by its ID
        if (!$product) {
            throw new \Exception("Product with ID {$export->product_id} not found.");
        }
        $product->quantity += $export->quantity; // Increase the product quantity
        $product->save();
    
        // Update the export status to "canceled"
        $export->status = 'canceled';
        $export->save();
    
        return $export;
    }

    public function markPending($global_id) {
        // Fetch the export record by global_id
        $export = $this->getByGlobalId($global_id);
    
        if (!$export) {
            throw new \Exception("Export with ID {$global_id} not found.");
        }
    
        // Check if the status is already "pending"
        if ($export->status === 'pending') {
            throw new \Exception("Export is already marked as pending.");
        }
    
        // Fetch the associated product
        $product = Product::where('id', $export->product_id)->first(); // Fetch the product by its ID
        if (!$product) {
            throw new \Exception("Product with ID {$export->product_id} not found.");
        }
    
        // Handle status transitions
        if ($export->status === 'canceled') {
            // If the status is "canceled", reduce the product quantity
            if ($product->quantity < $export->quantity) {
                throw new \Exception("Insufficient product quantity for export. Available: {$product->quantity}, Requested: {$export->quantity}.");
            }
            $product->quantity -= $export->quantity; // Reduce the product quantity
            $product->save();
        }
    
        // Update the export status to "pending"
        $export->status = 'pending';
        $export->save();
    
        return $export;
    }
}