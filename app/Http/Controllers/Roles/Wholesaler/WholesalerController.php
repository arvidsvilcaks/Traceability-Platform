<?php

namespace App\Http\Controllers\Roles\Wholesaler;

use App\Http\Controllers\Controller;
use App\Models\Quality;
use App\Models\Processes;
use App\Models\Markets;
use App\Models\User;
use App\Models\Products;
use App\Models\Traceability;
use Illuminate\Http\Request;

class WholesalerController extends Controller
{
    public function index($product_id)
    {
        //$traceabilityWholesaler = Traceability::where('product_id', $product_id)->get();
        $processesWholesaler = Processes::where('product_id', $product_id)->get();
        $qualityWholesaler = Quality::where('product_id', $product_id)->get();
        $market = Markets::where('product_id', $product_id)->get();
        $honeyInfo = Products::where('id', $product_id)->latest()->first();
        $packaging = User::where('role', 'Packaging company')->get();

        return view('roles.Wholesaler', data: compact('processesWholesaler', 'qualityWholesaler', 'market', 'honeyInfo', 'packaging'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'packaging_id' => 'nullable|exists:users,id',
        ]);
    
        $products = Products::findOrFail($request->product_id);
    
        if ($request->has('packaging_id')) {
            $products->packaging_id = $request->packaging_id ?: null;
        }
    
        $products->save();
    
        return redirect()->back()->with('success', 'Product info updated successfully');
    }
}