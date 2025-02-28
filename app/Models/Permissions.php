<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permissions extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = [
        'user_id',
        'product_id',
    ];
}
