<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Processes extends Model
{
    use HasFactory;

    protected $table = 'processes';

    protected $fillable = [
        'process',
        'description',
        'add_visual_materials',
        'product_id',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
