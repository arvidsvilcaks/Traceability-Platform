<?php

namespace App\Http\Controllers\Roles\Beekeeper;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        $request->validate([
            'date_of_production' => 'required|date',
            'honey_type' => 'required|string',
            'quantity' => 'required|integer',
            'add_analysis_results' => 'nullable|mimes:pdf,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('add_analysis_results')) {
            $filePath = $request->file('add_analysis_results')->store('analysis_files', 'public');
        }
        
        Products::create([
            'date_of_production' => $request->date_of_production,
            'honey_type' => $request->honey_type,
            'quantity' => $request->quantity,
            'add_analysis_results' => $filePath
        ]);

        return redirect()->back()->with('success', 'Product info added successfully');
    }

    public function updateProduct(Request $request, $id)
    {
        $honeyInfo = Products::findOrFail($id);

        $request->validate([
            'date_of_production' => 'required|date',
            'honey_type' => 'required|string',
            'quantity' => 'required|numeric',
            'add_analysis_results' => 'nullable|mimes:pdf,docx|max:2048',
        ]);

        if ($request->hasFile('add_analysis_results')) {
            if ($honeyInfo->add_analysis_results) {
                Storage::disk('public')->delete($honeyInfo->add_analysis_results);
            }
            $honeyInfo->add_analysis_results = $request->file('add_analysis_results')->store('analysis_files', 'public');
        }

        $honeyInfo->update([
            'date_of_production' => $request->date_of_production,
            'honey_type' => $request->honey_type,
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Product info updated successfully');
    }

    public function deleteProduct($id)
    {
        $honeyInfo = Products::findOrFail($id);

        if ($honeyInfo->add_visual_materials) {
            Storage::disk('public')->delete($honeyInfo->add_visual_materials);
        }

        $honeyInfo->delete();

        return redirect()->back()->with('success', 'Product info deleted successfully');
    }
}