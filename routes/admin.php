<?php

use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\SupplierController;
use App\Http\Controllers\Api\v1\ImportController;
use App\Http\Controllers\Api\v1\ExportController;

Route::get('users/{global_id}', [UserController::class, 'getUser']);
Route::get('users', [UserController::class, 'getAllUsers']);
Route::post('users', [UserController::class, 'createUser']);
Route::put('users/{global_id}', [UserController::class, 'updateUser']);
Route::delete('users/{global_id}', [UserController::class, 'deleteUser']);

Route::get('categories/{id}', [CategoryController::class, 'getCategory']);
Route::get('categories', [CategoryController::class, 'getAllCategories']);
Route::post('categories', [CategoryController::class, 'createCategory']);
Route::put('categories/{id}', [CategoryController::class, 'updateCategory']);
Route::delete('categories/{id}', [CategoryController::class, 'deleteCategory']);

Route::get('products/{id}', [ProductController::class, 'getProduct']);
Route::get('products', [ProductController::class, 'getAllProducts']);
Route::post('products', [ProductController::class, 'createProduct']);
Route::put('products/{id}', [ProductController::class, 'updateProduct']);
Route::delete('products/{id}', [ProductController::class, 'deleteProduct']);

Route::get('suppliers/{id}', [SupplierController::class, 'getSupplier']);
Route::get('suppliers', [SupplierController::class, 'getAllSuppliers']);
Route::post('suppliers', [SupplierController::class, 'createSupplier']);
Route::put('suppliers/{id}', [SupplierController::class, 'updateSupplier']);
Route::delete('suppliers/{id}', [SupplierController::class, 'deleteSupplier']);

Route::get('imports/{global_id}', [ImportController::class, 'getImport']);
Route::get('imports', [ImportController::class, 'getAllImports']);
Route::post('imports', [ImportController::class, 'createImport']);
Route::put('imports/{global_id}', [ImportController::class, 'updateImport']);
Route::delete('imports/{global_id}', [ImportController::class, 'deleteImport']);
Route::put('imports/{global_id}/mark-received', [ImportController::class, 'markImportAsReceived']);
Route::put('imports/{global_id}/mark-canceled', [ImportController::class, 'markImportAsCanceled']);
Route::put('imports/{global_id}/mark-pending', [ImportController::class, 'markImportAsPending']);

Route::get('exports/{global_id}', [ExportController::class, 'getExport']);
Route::get('exports', [ExportController::class, 'getAllExports']);
Route::post('exports', [ExportController::class, 'createExport']);
Route::put('exports/{global_id}', [ExportController::class, 'updateExport']);
Route::delete('exports/{global_id}', [ExportController::class, 'deleteExport']);
Route::put('exports/{global_id}/mark-shipped', [ExportController::class, 'markExportAsShipped']);
Route::put('exports/{global_id}/mark-canceled', [ExportController::class, 'markExportAsCanceled']);
Route::put('exports/{global_id}/mark-pending', [ExportController::class, 'markExportAsPending']);