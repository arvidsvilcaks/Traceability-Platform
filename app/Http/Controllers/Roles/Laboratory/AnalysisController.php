<?php

namespace App\Http\Controllers\Roles\Laboratory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Honey;
use Illuminate\Support\Facades\Storage;

class AnalysisController extends Controller
{
    public function storeAnalysis(Request $request)
    {
        $request->validate([
            'add_analysis_results' => 'nullable|mimes:pdf,docx|max:2048'
        ]);

        $filePath3 = null;
        if ($request->hasFile('add_analysis_results')) {
            $filePath3 = $request->file('add_analysis_results')->store('analysis_files', 'public');
        }

        Honey::create([
            'add_analysis_results' => $filePath3,
        ]);

        return redirect()->route('laboratory.index')->with('success', 'Analysis info added successfully.');
    }

    public function updateAnalysis(Request $request, $id)
    {
        $analysis = Honey::findOrFail($id);

        $request->validate([
            'add_analysis_results' => 'nullable|mimes:pdf,docx|max:2048'
        ]);

        if ($request->hasFile('add_analysis_results')) {
            if ($analysis->add_analysis_results) {
                Storage::disk('public')->delete($analysis->add_analysis_results);
            }
            $analysis->add_analysis_results = $request->file('add_analysis_results')->store('analysis_files', 'public');
        }

        $analysis->save();

        return redirect()->route('laboratory.index', ['honey_id' => $id])->with('success', 'Analysis info updated successfully.');
    }

    public function destroyAnalysis($id)
    {
        $honeyInfo = Honey::findOrFail($id);

        if ($honeyInfo->add_analysis_results) {
            Storage::disk('public')->delete($honeyInfo->add_analysis_results);
            $honeyInfo->add_analysis_results = null;
            $honeyInfo->save();
        }

        return redirect()->back()->with('success', 'Honey analysis results deleted successfully');
    }
}
