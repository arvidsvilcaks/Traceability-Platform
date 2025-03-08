<?php

namespace App\Http\Controllers\Roles\Packaging;

use App\Http\Controllers\Controller;
use App\Models\Processes;
use App\Models\Products;
use App\Models\Quality;
use App\Models\Packages;
use App\Models\Markets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Traceability;

class PackagingController extends Controller
{
    public function index($product_id)
    {
        $user = Auth::user();
        
        //$traceabilityPackaging = Traceability::where('product_id', $product_id)->get();
        $processesPackaging = Processes::where('product_id', $product_id)
        ->where('user_id', $user->id)
        ->get();        
        $qualityPackaging = Quality::where('product_id', $product_id)
        ->where('user_id', $user->id)
        ->get();        
        $honeyInfo = Products::where('id', $product_id)->latest()->first();
        $packages = Packages::where('product_id', $product_id)->get();
        $markets = Markets::where('product_id', $product_id)->get(); // Fetch available markets

        return view('roles.Packaging', data: compact('processesPackaging', 'qualityPackaging', 'honeyInfo', 'packages', 'markets'));
    }
    public function storePackage(Request $request, $product_id)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'package_weight' => 'required|numeric',
            'type' => 'required|string',
            'market_id' => 'nullable|exists:markets,id'
        ]);
    
        Packages::create([
            'quantity' => $request->quantity,
            'package_weight' => $request->package_weight,
            'type' => $request->type,
            'product_id' => $product_id,
            'market_id' => $request->market_id
        ]);
    
        return redirect()->route('packaging.index', ['product_id' => $product_id])->with('success', 'Package added successfully.');
    }
    

    public function updatePackage(Request $request, $id)
    {
        $packages = Packages::findOrFail($id);
    
        $request->validate([
            'quantity' => 'required|integer',
            'package_weight' => 'required|numeric',
            'type' => 'required|string',
            'market_id' => 'nullable|exists:markets,id'
        ]);
    
        $packages->update([
            'quantity' => $request->quantity,
            'package_weight' => $request->package_weight,
            'type' => $request->type,
            'market_id' => $request->market_id
        ]);
    
        return redirect()->route('packaging.index', ['product_id' => $packages->product_id])->with('success', 'Package updated successfully.');
    }
    

    public function destroyPackage($id)
    {
        $packages = Packages::findOrFail($id);

        $packages->delete();
        return redirect()->route('packaging.index', ['product_id' => $packages->product_id])->with('success', 'Process info deleted successfully.');
    }
}