<?php

namespace App\Http\Controllers\Roles\Wholesaler;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Processes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcessWholesalerController extends Controller
{
    public function storeProcess(Request $request, $product_id)
    {
        $request->validate([
            'process' => 'required|string',
            'description' => 'required|string',
            'add_visual_materials' => 'nullable|mimes:pdf,docx,jpg,png,jpeg|max:2048'
        ]);

        $filePath = null;
        if ($request->hasFile('add_visual_materials')) {
            $filePath = $request->file('add_visual_materials')->store('process_files', 'public');
        }

        Processes::create([
            'process' => $request->process,
            'description' => $request->description,
            'add_visual_materials' => $filePath,
            'product_id' => $product_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('wholesaler.index', ['product_id' => $product_id])->with('success', 'Process info added successfully.');
    }

    public function updateProcess(Request $request, $id)
    {
        $processesWholesaler = Processes::findOrFail($id);

        $request->validate([
            'process' => 'required|string',
            'description' => 'required|string',
            'add_visual_materials' => 'nullable|mimes:pdf,docx,jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('add_visual_materials')) {
            if ($processesWholesaler->add_visual_materials) {
                Storage::disk('public')->delete($processesWholesaler->add_visual_materials);
            }
            $processesWholesaler->add_visual_materials = $request->file('add_visual_materials')->store('process_files', 'public');
        }

        $processesWholesaler->update([
            'process' => $request->process,
            'description' => $request->description,
        ]);

        return redirect()->route('wholesaler.index', ['product_id' => $processesWholesaler->product_id])->with('success', 'Process info updated successfully.');
    }

    public function destroyProcess($id)
    {
        $processesWholesaler = Processes::findOrFail($id);

        if ($processesWholesaler->add_visual_materials) {
            Storage::disk('public')->delete($processesWholesaler->add_visual_materials);
        }

        $processesWholesaler->delete();
        return redirect()->route('wholesaler.index', ['product_id' => $processesWholesaler->product_id])->with('success', 'Process info deleted successfully.');
    }
    public function destroyVisualMaterial($id)
    {
        $processesWholesaler = Processes::findOrFail($id);

        if ($processesWholesaler->add_visual_materials) {
            Storage::disk('public')->delete($processesWholesaler->add_visual_materials);
            $processesWholesaler->update(['add_visual_materials' => null]);
        }

        return redirect()->route('wholesaler.index', ['product_id' => $processesWholesaler->product_id])->with('success', 'Visual material deleted successfully.');
    }
}
