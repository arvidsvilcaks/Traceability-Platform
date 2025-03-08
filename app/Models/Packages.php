<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Packages extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $fillable = [
        'type',
        'quantity',
        'product_id',
        'market_id',
        'package_weight'
    ];
    public function market()
    {
        return $this->belongsTo(Markets::class, 'market_id');
    }
}
