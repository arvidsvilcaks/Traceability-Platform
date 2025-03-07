<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'packaging_id'
    ];

    public function packagingCompany()
    {
        return $this->belongsTo(User::class, 'packaging_id');
    }
    public function honeys()
    {
        return $this->belongsToMany(Honey::class, 'honey_products', 'product_id', 'honey_id');
    }
}
