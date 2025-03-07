<?php

namespace App\Http\Controllers\Roles\Wholesaler;

use App\Http\Controllers\Controller;
use App\Models\Quality;
use Illuminate\Http\Request;

class QualityWholesalerController extends Controller
{
    public function storeHoneyQuality(Request $request, $product_id)
    {
        $request->validate([
            'metric' => 'required|string',
            'value' => 'required|string',
        ]);


        Quality::create([
            'metric' => $request->metric,
            'value' => $request->value,
            'product_id' => $product_id,
        ]);

        return redirect()->route('wholesaler.index', ['product_id' => $product_id])->with('success', 'Quality info added successfully.');
    }

    public function updateHoneyQuality(Request $request, $id)
    {
        $qualityWholesaler = Quality::findOrFail($id);

        $request->validate([
            'metric' => 'required|string',
            'value' => 'required|string',
        ]);

        $qualityWholesaler->update([
            'metric' => $request->metric,
            'value' => $request->value,
        ]);

        return redirect()->route('wholesaler.index', ['product_id' => $qualityWholesaler->product_id])->with('success', 'Quality info updated successfully.');
    }

    public function destroyHoneyQuality($id)
    {
        $qualityWholesaler = Quality::findOrFail($id);
        $qualityWholesaler->delete();
        return redirect()->route('wholesaler.index', ['product_id' => $qualityWholesaler->product_id])->with('success', 'Quality info deleted successfully.');
    }
}
