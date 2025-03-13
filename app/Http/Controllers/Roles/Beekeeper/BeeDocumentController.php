<?php

namespace App\Http\Controllers\Roles\Beekeeper;

use App\Http\Controllers\Controller;
use App\Models\BeekeepingDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeeDocumentController extends Controller
{
    public function storeDocument(Request $request, $honey_id)
    {
        $request->validate([
            'add_beekeeping_documents' => 'nullable|mimes:pdf,docx|max:2048',
        ]);

        $filePath2 = null;
        if ($request->hasFile('add_beekeeping_documents')) {
            $filePath2 = $request->file('add_beekeeping_documents')->store('beekeeping_files', 'public');
        }

        BeekeepingDocuments::create([
            'add_beekeeping_documents' => $filePath2,
            'honey_id' => $honey_id
        ]); 

        return redirect()->route('beekeeper.index', ['honey_id' => $honey_id])->with('success', 'Apiary info added successfully.');
    }

    public function updateDocument(Request $request, $id)
    {
        $beekeepingDocuments = BeekeepingDocuments::findOrFail($id);

        $request->validate([
            'add_beekeeping_documents' => 'nullable|mimes:pdf,docx|max:2048',
        ]);

        if ($request->hasFile('add_beekeeping_documents')) {
            if ($beekeepingDocuments->add_beekeeping_documents) {
                Storage::disk('public')->delete($beekeepingDocuments->add_beekeeping_documents);
            }
            $beekeepingDocuments->add_beekeeping_documents = $request->file('add_beekeeping_documents')->store('beekeeping_files', 'public');
        }
        $beekeepingDocuments->save();

        return redirect()->route('beekeeper.index', ['honey_id' => $beekeepingDocuments->honey_id])
        ->with('success', 'Apiary info updated successfully.');    
    }
    
    public function destroyDocument($id)
    {
        $beekeepingDocuments = BeekeepingDocuments::findOrFail($id);
        
        if ($beekeepingDocuments->add_beekeeping_documents) {
            Storage::disk('public')->delete($beekeepingDocuments->add_beekeeping_documents);
        }
        $beekeepingDocuments->delete();

        return redirect()->route('beekeeper.index', ['honey_id' => $beekeepingDocuments->honey_id])
        ->with('success', 'Apiary info deleted successfully.');
    }
}