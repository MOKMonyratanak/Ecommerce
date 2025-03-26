<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class Export extends Model {
    use HasFactory, UuidTrait;
    protected $keyType = 'string';
    protected $primaryKey = 'global_id';

    protected $table = 'exports';
    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
        'price',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}