<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Packages extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $fillable = [
        'type',
        'quantity',
        'product_id',
        'market_id',
        'package_weight',
        'qr_code'
    ];
    public function market()
    {
        return $this->belongsTo(Markets::class, 'market_id');
    }
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($package) {
    //         if (empty($package->qr_code)) {
    //             $package->qr_code = Str::uuid()->toString();
    //         }
    //     });
    // }
}
