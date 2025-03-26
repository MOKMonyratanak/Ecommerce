<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class Import extends Model
{
    use HasFactory, UuidTrait;
    protected $table = 'imports';
    protected $keyType = 'string';
    protected $primaryKey = 'global_id';

    protected $fillable = [
        'supplier_id',
        'product_id',
        'status',
        'quantity',
        'price',
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}