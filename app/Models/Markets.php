<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Markets extends Model
{
    use HasFactory;

    protected $table = 'markets';

    protected $fillable = [
        'name',
        'address',
        'package_id',
        'product_id',
    ];
}
