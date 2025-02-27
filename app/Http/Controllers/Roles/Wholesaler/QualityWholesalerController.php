<?php

namespace App\Http\Controllers\Roles\Wholesaler;

use App\Http\Controllers\Controller;
use App\Models\HoneyQuality;
use Illuminate\Http\Request;

class QualityWholesalerController extends Controller
{
    public function storeHoneyQuality(Request $request, $product_id)
    {
        $request->validate([
            'quality_standard' => 'required|string',
            'value' => 'required|string',
        ]);


        HoneyQuality::create([
            'quality_standard' => $request->quality_standard,
            'value' => $request->value,
            'product_id' => $product_id,
        ]);

        return redirect()->route('wholesaler.index', ['product_id' => $product_id])->with('success', 'Quality info added successfully.');
    }

    public function updateHoneyQuality(Request $request, $id)
    {
        $qualityWholesaler = HoneyQuality::findOrFail($id);

        $request->validate([
            'quality_standard' => 'required|string',
            'value' => 'required|string',
        ]);

        $qualityWholesaler->update([
            'quality_standard' => $request->quality_standard,
            'value' => $request->value,
        ]);

        return redirect()->route('wholesaler.index', ['product_id' => $qualityWholesaler->product_id])->with('success', 'Quality info updated successfully.');
    }

    public function destroyHoneyQuality($id)
    {
        $qualityWholesaler = HoneyQuality::findOrFail($id);
        $qualityWholesaler->delete();
        return redirect()->route('wholesaler.index', ['product_id' => $qualityWholesaler->product_id])->with('success', 'Quality info deleted successfully.');
    }
}
