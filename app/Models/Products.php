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
        'packaging_id',
        'wholesaler_id'
    ];
    public function packaging()
    {
        return $this->belongsTo(User::class, 'packaging_id');
    }
    public function wholesaler()
    {
        return $this->belongsTo(User::class, 'wholesaler_id');
    }
    public function honeys()
    {
        return $this->belongsToMany(Honey::class, 'honey_products', 'product_id', 'honey_id');
    }
    public function quality()
    {
        return $this->hasMany(Quality::class, 'product_id');
    }
    public function processes()
    {
        return $this->hasMany(Processes::class, 'product_id');
    }
    public function traceability()
    {
        return $this->hasMany(Traceability::class, 'product_id');
    }
}
