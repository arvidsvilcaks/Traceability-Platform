<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Traceability;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TraceabilityController extends Controller
{
    /**
     * Store laboratory traceability data.
     */
    public function storeLaboratoryTrace(Request $request, $product_id)
    {
        $request->validate([
            'dateLaboratory' => 'nullable|date',
            'latitudeLaboratory' => 'nullable|numeric',
            'longitudeLaboratory' => 'nullable|numeric',
        ]);

        Traceability::create([
            'product_id' => $product_id,
            'dateLaboratory' => $request->dateLaboratory,
            'latitudeLaboratory' => $request->latitudeLaboratory,
            'longitudeLaboratory' => $request->longitudeLaboratory,
        ]);
        return redirect()->route('laboratory.index', ['product_id' => $product_id])->with('success', 'Trace info added successfully.');

    }

    /**
     * Update laboratory traceability data.
     */
    public function updateLaboratoryTrace(Request $request, $id)
    {
        $traceabilityLaboratory = Traceability::find($id);

        $request->validate([
            'dateLaboratory' => 'nullable|date',
            'latitudeLaboratory' => 'nullable|numeric',
            'longitudeLaboratory' => 'nullable|numeric',
        ]);

        $traceabilityLaboratory->update([
            'dateLaboratory' => $request->dateLaboratory,
            'latitudeLaboratory' => $request->latitudeLaboratory,
            'longitudeLaboratory' => $request->longitudeLaboratory,
        ]);

        return redirect()->route('laboratory.index', ['product_id' => $traceabilityLaboratory->product_id])->with('success', 'Trace info added successfully.');
    }

    /**
     * Delete laboratory traceability data.
     */
    public function deleteLaboratoryTrace($id)
    {
        // Find existing traceability record
        $traceabilityLaboratory = Traceability::find($id);
    
    
        // Update the fields to null instead of deleting the record
        $traceabilityLaboratory->update([
            'latitudeLaboratory' => null,
            'longitudeLaboratory' => null,
            'dateLaboratory' => null,
        ]);
    
        return redirect()->route('laboratory.index', ['product_id' => $traceabilityLaboratory->product_id])->with('success', 'Trace info added successfully.');
    }
    
}
