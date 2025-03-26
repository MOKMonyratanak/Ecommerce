<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class Supplier extends Model
{
    use HasFactory, UuidTrait;
    protected $table = 'suppliers';
    protected $keyType = 'string';
    protected $primaryKey = 'global_id';

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'address',
        'is_active',
    ];

    public function imports() {
        return $this->hasMany(Import::class);
    }
}