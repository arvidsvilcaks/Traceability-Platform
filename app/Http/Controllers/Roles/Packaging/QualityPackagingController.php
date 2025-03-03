<?php

namespace App\Http\Controllers\Roles\Packaging;

use App\Http\Controllers\Controller;
use App\Models\HoneyQuality;
use Illuminate\Http\Request;

class QualityPackagingController extends Controller
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

        return redirect()->route('packaging.index', ['product_id' => $product_id])->with('success', 'Quality info added successfully.');
    }

    public function updateHoneyQuality(Request $request, $id)
    {
        $qualityPackaging = HoneyQuality::findOrFail($id);

        $request->validate([
            'quality_standard' => 'required|string',
            'value' => 'required|string',
        ]);

        $qualityPackaging->update([
            'quality_standard' => $request->quality_standard,
            'value' => $request->value,
        ]);

        return redirect()->route('packaging.index', ['product_id' => $qualityPackaging->product_id])->with('success', 'Quality info updated successfully.');
    }

    public function destroyHoneyQuality($id)
    {
        $qualityPackaging = HoneyQuality::findOrFail($id);
        $qualityPackaging->delete();
        return redirect()->route('packaging.index', ['product_id' => $qualityPackaging->product_id])->with('success', 'Quality info deleted successfully.');
    }
}
