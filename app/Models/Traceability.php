<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traceability extends Model
{
    use HasFactory;

    protected $table = 'traceability';

    protected $fillable = [
        'address',
        'longitude',
        'latitude',
        'stage',
        'honey_id'
    ];

    public function honey()
    {
        return $this->belongsTo(Honey::class, 'honey_id');
    }

    // Static function to fetch all records
    public static function getAll()
    {
        return self::all();
    }

    // Static function to create a new traceability record
    public static function createTraceability($data)
    {
        return self::create($data);
    }

    // Static function to update a record
    public static function updateTraceability($id, $data)
    {
        $traceability = self::findOrFail($id);
        return $traceability->update($data);
    }

    // Static function to delete a record
    public static function deleteTraceability($id)
    {
        return self::findOrFail($id)->delete();
    }
}
