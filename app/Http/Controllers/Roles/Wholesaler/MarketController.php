<?php

namespace App\Http\Controllers\Roles\Wholesaler;

use App\Http\Controllers\Controller;
use App\Models\Markets;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function storeMarket(Request $request, $product_id)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
        ]);


        Markets::create([
            'name' => $request->name,
            'address' => $request->address,
            'product_id' => $product_id,
        ]);

        return redirect()->route('wholesaler.index', ['product_id' => $product_id])->with('success', 'Market info added successfully.');
    }

    public function updateMarket(Request $request, $id)
    {
        $market = Markets::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
        ]);

        $market->update([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('wholesaler.index', ['product_id' => $market->product_id])->with('success', 'Market info updated successfully.');
    }

    public function destroyMarket($id)
    {
        $market = Markets::findOrFail($id);
        $market->delete();
        return redirect()->route('wholesaler.index', ['product_id' => $market->product_id])->with('success', 'Market info deleted successfully.');
    }
}
