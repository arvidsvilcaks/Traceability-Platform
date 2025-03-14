<?php

namespace App\Http\Controllers\Roles;

use App\Models\Honey;
use App\Models\Products;
use App\Models\Packages;
use App\Models\BeekeepingDocuments;
use App\Http\Controllers\Controller;

class TraceabilityController extends Controller
{
    public function indexPackage($package_id)
    {
        $package = Packages::with([
            'market',
            'product.honeys.traceability',
            'product.honeys.apiary.beekeeper',
            'product.honeys.apiary',
            'product.honeys.beekeeper',
            'product.honeys.laboratoryEmployee',
            'product.honeys.wholesaler',
            'product.honeys',
            'product.quality',
            'product.processes',
            'product.traceability',
            'product.packaging',
            'product.wholesaler'
        ])->find($package_id);
    
        return view('roles.consumerPackage', compact('package'));
    }
    public function indexProduct($product_id)
    {
        $product = Products::with([
            'honeys.traceability',
            'honeys.apiary.beekeeper',
            'honeys.apiary',
            'honeys.beekeeper',
            'honeys.laboratoryEmployee',
            'honeys.wholesaler',
            'honeys',
            'quality',
            'processes',
            'traceability',
            'packaging',
            'wholesaler'
        ])->find($product_id);
    
        return view('roles.consumerProduct', compact('product'));
    }
    public function indexHoney($honey_id)
    {
        $honey = Honey::with([
            'traceability',
            'apiary.beekeeper',
            'beekeeper',
            'laboratoryEmployee',
            'wholesaler'
        ])->find($honey_id);
    
        if (!$honey) {
            return redirect()->back()->with('error', 'Honey not found');
        }
    
        $beekeepingDocuments = BeekeepingDocuments::where('honey_id', $honey_id)->get();
    
        return view('roles.consumerHoney', compact('honey', 'beekeepingDocuments'));
    }
}
