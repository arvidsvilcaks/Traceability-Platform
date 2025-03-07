<?php

namespace App\Http\Controllers\Roles\Packaging;

use App\Http\Controllers\Controller;
use App\Models\Processes;
use App\Models\Products;
use App\Models\Quality;
use App\Models\Packages;
use Illuminate\Http\Request;
use App\Models\Traceability;

class PackagingController extends Controller
{
    public function index($product_id)
    {
        //$traceabilityPackaging = Traceability::where('product_id', $product_id)->get();
        $processesPackaging = Processes::where('product_id', $product_id)->get();
        $qualityPackaging = Quality::where('product_id', $product_id)->get();
        $honeyInfo = Products::where('id', $product_id)->latest()->first();
        $packages = Packages::where('product_id', $product_id)->get();

        return view('roles.Packaging', data: compact('processesPackaging', 'qualityPackaging', 'honeyInfo', 'packages'));
    }
    public function storePackage(Request $request, $product_id)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'type' => 'required|string',
        ]);

        Packages::create([
            'quantity' => $request->quantity,
            'type' => $request->type,
            'product_id' => $product_id
        ]);

        return redirect()->route('packaging.index', ['product_id' => $product_id])->with('success', 'Process info added successfully.');
    }

    public function updatePackage(Request $request, $id)
    {
        $packages = Packages::findOrFail($id);

        $request->validate([
            'quantity' => 'required|integer',
            'type' => 'required|string',
        ]);

        $packages->update([
            'quantity' => $request->quantity,
            'type' => $request->type,
        ]);

        return redirect()->route('packaging.index', ['product_id' => $packages->product_id])->with('success', 'Process info updated successfully.');
    }

    public function destroyPackage($id)
    {
        $packages = Packages::findOrFail($id);

        $packages->delete();
        return redirect()->route('packaging.index', ['product_id' => $packages->product_id])->with('success', 'Process info deleted successfully.');
    }
}