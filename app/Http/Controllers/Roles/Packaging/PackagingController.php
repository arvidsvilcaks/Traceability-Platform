<?php

namespace App\Http\Controllers\Roles\Packaging;

use App\Http\Controllers\Controller;
use App\Models\Processes;
use App\Models\HoneyQuality;
use App\Models\Products;
use App\Models\Traceability;

class PackagingController extends Controller
{
    public function index($product_id)
    {
        $traceabilityPackaging = Traceability::where('product_id', $product_id)->get();
        $processesPackaging = Processes::where('product_id', $product_id)->get();
        $qualityPackaging = HoneyQuality::where('product_id', $product_id)->get();
        $honeyInfo = Products::where('id', $product_id)->latest()->first();

        return view('roles.Packaging', data: compact('processesPackaging', 'qualityPackaging', 'honeyInfo', 'traceabilityPackaging'));
    }
}