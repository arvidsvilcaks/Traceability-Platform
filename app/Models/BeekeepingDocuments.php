<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BeekeepingDocuments extends Model
{
    use HasFactory;

    protected $table = 'beekeeping_documents';

    protected $fillable = [
        'add_beekeeping_documents',
        'honey_id'
    ];
    public function honey()
    {
        return $this->belongsTo(Honey::class, 'honey_id');
    }
}
