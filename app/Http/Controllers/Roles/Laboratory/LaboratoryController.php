<?php

namespace App\Http\Controllers\Roles\Laboratory;

use App\Http\Controllers\Controller;
use App\Models\Honey;
use App\Models\Traceability;

class LaboratoryController extends Controller
{
    public function index($honey_id)
    {
        $honeyInfo = Honey::where('id', $honey_id)->latest()->first();
        $traceabilityLaboratory = Traceability::where('honey_id', $honey_id)->get();

        return view('roles.laboratory', compact('honeyInfo', 'traceabilityLaboratory'));
    }
}
