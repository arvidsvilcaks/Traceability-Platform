<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products; 

class Traceability extends Model
{
    use HasFactory;

    protected $table = 'traceability';

    protected $fillable = [
        'dateLaboratory',
        'dateWholesaler',
        'datePackaging',
        'latitudeLaboratory',
        'longitudeLaboratory',
        'latitudeWholesaler',
        'longitudeWholesaler',
        'latitudePackaging',
        'longitudePackaging',
        'product_id',
    ];

    protected $spatialFields = [
        'locationLaboratory',
        'locationWholesaler',
        'locationPackaging'
    ];
}
