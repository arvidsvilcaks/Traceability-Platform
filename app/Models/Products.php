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
        'honey_type',
        'date_of_production',
        'quantity',
        'add_analysis_results',
        'qr_code'
    ];
}
