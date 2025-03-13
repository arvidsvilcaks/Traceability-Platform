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
        'honey_id',
        'product_id',
    ];

    public function honey()
    {
        return $this->belongsTo(Honey::class, 'honey_id');
    }    
    public function product()
    {
        return $this->belongsTo(Honey::class, 'product_id');
    }

    public static function getAll($honey_id = null)
    {
        $query = self::query();

        if ($honey_id !== null) {
            $query->where('honey_id', $honey_id);
        }

        return $query->get();
    }
    public static function getAll_2($product_id = null)
    {
        $query = self::query();

        if ($product_id !== null) {
            $query->where('product_id', $product_id);
        }

        return $query->get();
    }

    public static function createTraceability($data)
    {
        return self::create($data);
    }

    public static function updateTraceability($id, $data)
    {
        $traceability = self::findOrFail($id);
        return $traceability->update($data);
    }

    public static function deleteTraceability($id)
    {
        return self::findOrFail($id)->delete();
    }
    public static function createTraceabilityProduct($data)
    {
        return self::create($data);
    }

    public static function updateTraceabilityProduct($id, $data)
    {
        $traceability = self::findOrFail($id);
        return $traceability->update($data);
    }

    public static function deleteTraceabilityProduct($id)
    {
        return self::findOrFail($id)->delete();
    }
}
