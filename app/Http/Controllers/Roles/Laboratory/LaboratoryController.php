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
        $traceability = Traceability::getAll($honey_id);

        return view('roles.laboratory', compact('honeyInfo', 'traceability'));
    }
}
