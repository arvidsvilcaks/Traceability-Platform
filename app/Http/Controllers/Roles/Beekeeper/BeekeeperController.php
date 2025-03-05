<?php

namespace App\Http\Controllers\Roles\Beekeeper;

use App\Http\Controllers\Controller;
use App\Models\Apiary;
use App\Models\Honey;
use App\Models\BeekeepingDocuments;
use App\Models\Traceability;

class BeekeeperController extends Controller
{
    public function index($honey_id)
    {
        $honeyInfo = Honey::where('id', $honey_id)->first();
        $beekeepingDocuments = BeekeepingDocuments::where('honey_id', $honey_id)->get();
        $apiary = Apiary::where('honey_id', $honey_id)->get();
        $traceability = Traceability::where('honey_id', $honey_id)->get();
        
        return view('roles.beekeeper', compact('apiary', 'beekeepingDocuments', 'honeyInfo', 'traceability'));
    }
}
