<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use App\Models\Packages;
use App\Http\Controllers\Controller;

class TraceabilityController extends Controller
{
    public function index($package_id)
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
    
}
