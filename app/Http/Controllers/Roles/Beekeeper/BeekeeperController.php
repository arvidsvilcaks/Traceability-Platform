<?php

namespace App\Http\Controllers\Roles\Beekeeper;

use App\Http\Controllers\Controller;
use App\Models\Apiary;
use App\Models\Products;
use App\Models\BeekeepingDocuments;
use App\Models\Traceability;

class BeekeeperController extends Controller
{
    public function index($product_id)
    {
        $honeyInfo = Products::where('id', $product_id)->first();
        $beekeepingDocuments = BeekeepingDocuments::where('product_id', $product_id)->get();
        $apiary = Apiary::where('product_id', $product_id)->get();
        $traceability = Traceability::where('product_id', $product_id)->get();
        
        return view('roles.beekeeper', compact('apiary', 'beekeepingDocuments', 'honeyInfo', 'traceability'));
    }
}
