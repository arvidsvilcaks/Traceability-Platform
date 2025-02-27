<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HoneyQuality extends Model
{
    use HasFactory;

    protected $table = 'honey_quality';

    protected $fillable = [
        'quality_standard',
        'value',
        'product_id',
    ];
}
