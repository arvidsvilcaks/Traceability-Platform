<?php

namespace App\Http\Controllers\Roles\Packaging;

use App\Http\Controllers\Controller;
use App\Models\Processes;
use App\Models\HoneyQuality;
use App\Models\Products;

class PackagingController extends Controller
{
    public function index($product_id)
    {
        $processesPackaging = Processes::where('product_id', $product_id)->get();
        $qualityPackaging = HoneyQuality::where('product_id', $product_id)->get();
        $honeyInfo = Products::where('id', $product_id)->get();

        return view('roles.Packaging', data: compact('processesPackaging', 'qualityPackaging', 'honeyInfo'));
    }
}