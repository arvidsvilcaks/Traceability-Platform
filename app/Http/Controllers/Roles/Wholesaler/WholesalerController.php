<?php

namespace App\Http\Controllers\Roles\Wholesaler;

use App\Http\Controllers\Controller;
use App\Models\Quality;
use App\Models\Processes;
use App\Models\Markets;
use App\Models\Products;
use App\Models\Traceability;

class WholesalerController extends Controller
{
    public function index($product_id)
    {
        //$traceabilityWholesaler = Traceability::where('product_id', $product_id)->get();
        $processesWholesaler = Processes::where('product_id', $product_id)->get();
        $qualityWholesaler = Quality::where('product_id', $product_id)->get();
        $market = Markets::where('product_id', $product_id)->get();
        $honeyInfo = Products::where('id', $product_id)->latest()->first();

        return view('roles.Wholesaler', data: compact('processesWholesaler', 'qualityWholesaler', 'market', 'honeyInfo'));
    }
}