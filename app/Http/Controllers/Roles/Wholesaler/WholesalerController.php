<?php

namespace App\Http\Controllers\Roles\Wholesaler;

use App\Http\Controllers\Controller;
use App\Models\HoneyQuality;
use App\Models\Processes;
use App\Models\Markets;
use App\Models\Products;

class WholesalerController extends Controller
{
    public function index($product_id)
    {
        $processesWholesaler = Processes::where('product_id', $product_id)->get();
        $qualityWholesaler = HoneyQuality::where('product_id', $product_id)->get();
        $market = Markets::where('product_id', $product_id)->get();
        $honeyInfo = Products::where('id', $product_id)->get();

        return view('roles.Wholesaler', data: compact('processesWholesaler', 'qualityWholesaler', 'market', 'honeyInfo'));
    }
}