<?php

namespace App\Http\Controllers\Roles\Laboratory;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Traceability;

class LaboratoryController extends Controller
{
    public function index($product_id)
    {
        $honeyInfo = Products::where('id', $product_id)->latest()->first();
        $traceabilityLaboratory = Traceability::where('product_id', $product_id)->get();

        return view('roles.laboratory', compact('honeyInfo', 'traceabilityLaboratory'));
    }
}
