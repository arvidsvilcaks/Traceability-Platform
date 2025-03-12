<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apiary extends Model
{
    use HasFactory;

    protected $table = 'apiary';

    protected $fillable = [
        'description',
        'location',
        'floral_composition',
        'specifics_of_environment',
        'add_visual_materials',
        'beekeeper_id'
    ];
    public function beekeeper()
    {
        return $this->belongsTo(User::class, 'beekeeper_id');
    }
}
