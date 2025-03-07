<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quality extends Model
{
    use HasFactory;

    protected $table = 'quality';

    protected $fillable = [
        'metric',
        'value',
        'product_id',
    ];
}
