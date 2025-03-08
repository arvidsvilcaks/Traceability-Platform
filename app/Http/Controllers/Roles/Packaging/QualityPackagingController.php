<?php

namespace App\Http\Controllers\Roles\Packaging;

use App\Http\Controllers\Controller;
use App\Models\Quality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QualityPackagingController extends Controller
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
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('packaging.index', ['product_id' => $product_id])->with('success', 'Quality info added successfully.');
    }

    public function updateHoneyQuality(Request $request, $id)
    {
        $qualityPackaging = Quality::findOrFail($id);

        $request->validate([
            'metric' => 'required|string',
            'value' => 'required|string',
        ]);

        $qualityPackaging->update([
            'metric' => $request->metric,
            'value' => $request->value,
        ]);

        return redirect()->route('packaging.index', ['product_id' => $qualityPackaging->product_id])->with('success', 'Quality info updated successfully.');
    }

    public function destroyHoneyQuality($id)
    {
        $qualityPackaging = Quality::findOrFail($id);
        $qualityPackaging->delete();
        return redirect()->route('packaging.index', ['product_id' => $qualityPackaging->product_id])->with('success', 'Quality info deleted successfully.');
    }
}
