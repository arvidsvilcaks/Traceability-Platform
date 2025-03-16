<?php

namespace App\Http\Controllers\Roles\Packaging;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Processes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcessPackagingController extends Controller
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

        return redirect()->route('packaging.index', ['product_id' => $product_id])->with('success', 'Process info added successfully.');
    }

    public function updateProcess(Request $request, $id)
    {
        $processesPackaging = Processes::findOrFail($id);

        $request->validate([
            'process' => 'required|string',
            'description' => 'required|string',
            'add_visual_materials' => 'nullable|mimes:pdf,docx,jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('add_visual_materials')) {
            if ($processesPackaging->add_visual_materials) {
                Storage::disk('public')->delete($processesPackaging->add_visual_materials);
            }
            $processesPackaging->add_visual_materials = $request->file('add_visual_materials')->store('process_files', 'public');
        }

        $processesPackaging->update([
            'process' => $request->process,
            'description' => $request->description,
        ]);

        return redirect()->route('packaging.index', ['product_id' => $processesPackaging->product_id])->with('success', 'Process info updated successfully.');
    }

    public function destroyProcess($id)
    {
        $processesPackaging = Processes::findOrFail($id);

        if ($processesPackaging->add_visual_materials) {
            Storage::disk('public')->delete($processesPackaging->add_visual_materials);
        }

        $processesPackaging->delete();
        return redirect()->route('packaging.index', ['product_id' => $processesPackaging->product_id])->with('success', 'Process info deleted successfully.');
    }
}
