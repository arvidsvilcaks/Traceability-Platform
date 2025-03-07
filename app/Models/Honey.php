<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Honey extends Model
{
    use HasFactory;

    protected $table = 'honey';

    protected $fillable = [
        'name',
        'honey_type',
        'date_of_production',
        'quantity',
        'add_analysis_results',
        'qr_code',
        'beekeeper_id',
        'laboratory_id',
        'wholesaler_id',
        'is_available',
    ];

    public function beekeeper()
    {
        return $this->belongsTo(User::class, 'beekeeper_id');
    }

    public function laboratoryEmployee()
    {
        return $this->belongsTo(User::class, 'laboratory_id');
    }

    public function wholesaler()
    {
        return $this->belongsTo(User::class, 'wholesaler_id');
    }
    public function products()
    {
        return $this->belongsToMany(Products::class, 'honey_products', 'honey_id', 'product_id');
    }
}
