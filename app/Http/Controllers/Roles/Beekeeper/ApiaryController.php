<?php

namespace App\Http\Controllers\Roles\Beekeeper;

use App\Http\Controllers\Controller;
use App\Models\Apiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiaryController extends Controller
{
    public function storeApiary(Request $request, $product_id)
    {
        $request->validate([
            'description' => 'required|string',
            'location' => 'required|string',
            'floral_composition' => 'required|string',
            'specifics_of_environment' => 'required|string',
            'add_visual_materials' => 'nullable|mimes:pdf,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('add_visual_materials')) {
            $filePath = $request->file('add_visual_materials')->store('apiary_files', 'public');
        }

        Apiary::create([
            'description' => $request->description,
            'location' => $request->location,
            'floral_composition' => $request->floral_composition,
            'specifics_of_environment' => $request->specifics_of_environment,
            'add_visual_materials' => $filePath,
            'product_id' => $product_id
        ]);

        return redirect()->route('beekeeper.index', ['product_id' => $product_id])->with('success', 'Apiary info added successfully.');
    }

    public function updateApiary(Request $request, $id)
    {
        $apiary = Apiary::findOrFail($id);

        $request->validate([
            'description' => 'required|string',
            'location' => 'required|string',
            'floral_composition' => 'required|string',
            'specifics_of_environment' => 'required|string',
            'add_visual_materials' => 'nullable|mimes:pdf,docx|max:2048'
        ]);

        if ($request->hasFile('add_visual_materials')) {
            if ($apiary->add_visual_materials) {
                Storage::disk('public')->delete($apiary->add_visual_materials);
            }
            $apiary->add_visual_materials = $request->file('add_visual_materials')->store('apiary_files', 'public');
        }

        $apiary->update([
            'description' => $request->description,
            'location' => $request->location,
            'floral_composition' => $request->floral_composition,
            'specifics_of_environment' => $request->specifics_of_environment
        ]);

        return redirect()->route('beekeeper.index', ['product_id' => $apiary->product_id])
        ->with('success', 'Apiary info updated successfully.');
    }

    public function destroyApiary($id)
    {
        $apiary = Apiary::findOrFail($id);

        if ($apiary->add_visual_materials) {
            Storage::disk('public')->delete($apiary->add_visual_materials);
        }

        $apiary->delete();
        return redirect()->route('beekeeper.index', ['product_id' => $apiary->product_id])
        ->with('success', 'Apiary info deleted successfully.');
    }
}