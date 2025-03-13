<?php

namespace App\Http\Controllers\Roles\Wholesaler;

use App\Http\Controllers\Controller;
use App\Models\Quality;
use App\Models\Processes;
use App\Models\Markets;
use App\Models\User;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Traceability;

class WholesalerController extends Controller
{
    public function index($product_id)
    {
        $user = Auth::user();

        $processesWholesaler = Processes::where('product_id', $product_id)
        ->where('user_id', $user->id)
        ->get();

        $qualityWholesaler = Quality::where('product_id', $product_id)
        ->where('user_id', $user->id)
        ->get();

        $traceability = Traceability::getAll_2($product_id);

        $market = Markets::where('product_id', $product_id)->get();
        
        $honeyInfo = Products::where('id', $product_id)->latest()->first();

        $packaging = User::where('role', 'Packaging company')->get();

        return view('roles.wholesaler', data: compact('processesWholesaler', 'qualityWholesaler', 'market', 'honeyInfo', 'packaging', 'traceability'));
    }
    
    public function storeTraceabilityProduct(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'stage' => 'required|in:beekeeper,laboratory,wholesaler,packaging'
        ]);

        Traceability::create($request->all());

        return redirect()->back()->with('success', 'Traceability record added successfully.');
    }

    public function updateTraceabilityProduct(Request $request, $id)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'stage' => 'required|in:beekeeper,laboratory,wholesaler,packaging'
        ]);

        $traceability = Traceability::findOrFail($id);
        $traceability->update($request->all());

        return redirect()->back()->with('success', 'Traceability record updated successfully.');
    }
    
    public function destroyTraceabilityProduct($id)
    {
        Traceability::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Traceability record deleted successfully.');
    }

    public function assignPackaging(Request $request)
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