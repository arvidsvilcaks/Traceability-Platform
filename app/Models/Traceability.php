<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'honey_id',
        'addressLaboratory',
        'addressWholesaler',
        'addressPackaging',
    ];

    protected $spatialFields = [
        'locationLaboratory',
        'locationWholesaler',
        'locationPackaging'
    ];
}
