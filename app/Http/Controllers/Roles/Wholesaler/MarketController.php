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
            'market_name' => 'required|string',
            'market_location' => 'required|string',
        ]);


        Markets::create([
            'market_name' => $request->market_name,
            'market_location' => $request->market_location,
            'product_id' => $product_id,
        ]);

        return redirect()->route('wholesaler.index', ['product_id' => $product_id])->with('success', 'Market info added successfully.');
    }

    public function updateMarket(Request $request, $id)
    {
        $market = Markets::findOrFail($id);

        $request->validate([
            'market_name' => 'required|string',
            'market_location' => 'required|string',
        ]);

        $market->update([
            'market_name' => $request->market_name,
            'market_location' => $request->market_location,
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
