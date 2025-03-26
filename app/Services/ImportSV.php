<?php

namespace App\Services;

use App\Models\Import;
use App\Models\Product;

class ImportSV extends BaseService {
    public function getQuery() {
        return Import::query();
    }

    public function getImport($global_id) {
        return $this->getByGlobalId($global_id);
    }

    // public function getImportByID($id) {
    //     return $this->getByID($id);
    // }

    public function getAllImports($params = null) {
        return $this->getAll($params); // Use the getAll function from BaseService
    }

    public function createImport($data) {
        return $this->create($data);
    }

    public function updateImport($global_id, $data) {
        return $this->update($data, $global_id);
    }

    public function deleteImport($global_id) {
        return $this->softDelete($global_id);
    }

    public function markReceived($global_id) {
        $import = $this->getByGlobalId($global_id); // Fetch the import record by global_id
    
        if (!$import) {
            throw new \Exception("Import with ID {$global_id} not found.");
        }
    
        // Check if the status is already "received"
        if ($import->status === 'received') {
            return $import;
        }
    
        // Fetch the product using getByID
        $product = Product::where('id', $import->product_id)->first(); // Fetch the product by its ID
        if (!$product) {
            throw new \Exception("Product with ID {$import->product_id} not found.");
        }
    
        // Update the product quantity
        $product->quantity += $import->quantity; // Increase the product quantity
        $product->save();
    
        // Update the import status to "received"
        $import->status = 'received';
        $import->save();
    
        return $import;
    }

    public function markCanceled($global_id) {
        $import = $this->getByGlobalId($global_id); // Fetch the import record by global_id

        if (!$import) {
            throw new \Exception("Import with ID {$global_id} not found.");
        }

        // Check if the status is already "canceled"
        if ($import->status === 'canceled') {
            return $import;
        }

        // Fetch the associated product
        $product = Product::where('id', $import->product_id)->first(); // Assuming there's a relationship defined in the Import model
        if (!$product) {
            throw new \Exception("Product associated with this import not found.");
        }

        // Handle status transitions
        if ($import->status === 'received') {
            // If the status is "received", decrease the product quantity
            $product->quantity -= $import->quantity; // Decrease the product quantity
            if ($product->quantity < 0) {
                throw new \Exception("Product quantity cannot be negative.");
            }
            $product->save();
        }

        // Update the import status to "canceled"
        $import->status = 'canceled';
        $import->save();

        return $import;
    }

    public function markPending($global_id) {
        $import = $this->getByGlobalId($global_id); // Fetch the import record by global_id

        if (!$import) {
            throw new \Exception("Import with ID {$global_id} not found.");
        }

        // Check if the status is already "pending"
        if ($import->status === 'pending') {
            return $import;
        }

        // Fetch the associated product
        $product = Product::where('id', $import->product_id)->first(); // Assuming there's a relationship defined in the Import model
        if (!$product) {
            throw new \Exception("Product associated with this import not found.");
        }

        // Handle status transitions
        if ($import->status === 'received') {
            // If the status is "received", decrease the product quantity
            $product->quantity -= $import->quantity; // Decrease the product quantity
            if ($product->quantity < 0) {
                throw new \Exception("Product quantity cannot be negative.");
            }
            $product->save();
        }

        // Update the import status to "pending"
        $import->status = 'pending';
        $import->save();

        return $import;
    }

}