<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HoneyProducts extends Model
{
    use HasFactory;

    protected $table = 'honey_products';

    protected $fillable = [
        'product_id',
        'honey_id'
    ];
}
