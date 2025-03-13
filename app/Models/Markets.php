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
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    public function package()
    {
        return $this->belongsTo(Packages::class, 'package_id');
    }
}
