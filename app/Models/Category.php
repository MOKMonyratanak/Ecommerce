<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class Category extends Model
{
    use HasFactory, UuidTrait;
    protected $keyType = 'string';
    protected $primaryKey = 'global_id';
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    
}
