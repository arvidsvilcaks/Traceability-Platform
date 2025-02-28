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
            'addressLaboratory' => 'required|string|',
        ]);

        Traceability::create([
            'product_id' => $product_id,
            'dateLaboratory' => $request->dateLaboratory,
            'latitudeLaboratory' => $request->latitudeLaboratory,
            'longitudeLaboratory' => $request->longitudeLaboratory,
            'addressLaboratory' => $request->addressLaboratory,
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
            'addressLaboratory' => 'required|string|',
        ]);

        $traceabilityLaboratory->update([
            'dateLaboratory' => $request->dateLaboratory,
            'latitudeLaboratory' => $request->latitudeLaboratory,
            'longitudeLaboratory' => $request->longitudeLaboratory,
            'addressLaboratory' => $request->addressLaboratory,
        ]);

        return redirect()->route('laboratory.index', ['product_id' => $traceabilityLaboratory->product_id])->with('success', 'Trace info added successfully.');
    }

    /**
     * Delete laboratory traceability data.
     */
    public function removeLaboratoryTrace($id)
    {
        $traceabilityLaboratory = Traceability::find($id);
    
    
        $traceabilityLaboratory->update([
            'latitudeLaboratory' => null,
            'longitudeLaboratory' => null,
            'dateLaboratory' => null,
            'addressLaboratory' => null,
        ]);
    
        return redirect()->route('laboratory.index', ['product_id' => $traceabilityLaboratory->product_id])->with('success', 'Trace info added successfully.');
    }

        /**
     * Store wholesaler traceability data.
     */
    public function storeWholesalerTrace(Request $request, $product_id)
    {
        $request->validate([
            'dateWholesaler' => 'nullable|date',
            'latitudeWholesaler' => 'nullable|numeric',
            'longitudeWholesaler' => 'nullable|numeric',
            'addressWholesaler' => 'required|string|',
        ]);

        Traceability::create([
            'product_id' => $product_id,
            'datedateWholesaler' => $request->datedateWholesaler,
            'latitudedateWholesaler' => $request->latitudedateWholesaler,
            'longitudedateWholesaler' => $request->longitudedateWholesaler,
            'addressdateWholesaler' => $request->addressdateWholesaler,
        ]);
        return redirect()->route('wholesaler.index', ['product_id' => $product_id])->with('success', 'Trace info added successfully.');

    }

    /**
     * Update wholesaler traceability data.
     */
    public function updateWholesalerTrace(Request $request, $id)
    {
        $traceabilityWholesaler = Traceability::find($id);

        $request->validate([
            'dateWholesaler' => 'nullable|date',
            'latitudeWholesaler' => 'nullable|numeric',
            'longitudeWholesaler' => 'nullable|numeric',
            'addressWholesaler' => 'required|string|',
        ]);

        $traceabilityWholesaler->update([
            'dateWholesaler' => $request->dateWholesaler,
            'latitudeWholesaler' => $request->latitudeWholesaler,
            'longitudeWholesaler' => $request->longitudeWholesaler,
            'addressWholesaler' => $request->addressWholesaler,
        ]);

        return redirect()->route('wholesaler.index', ['product_id' => $traceabilityWholesaler->product_id])->with('success', 'Trace info added successfully.');
    }

    /**
     * Delete wholesaler traceability data.
     */
    public function removeWholesalerTrace($id)
    {
        $traceabilityWholesaler = Traceability::find($id);
    
    
        $traceabilityWholesaler->update([
            'latitudeWholesaler' => null,
            'longitudeWholesaler' => null,
            'dateWholesaler' => null,
            'addressWholesaler' => null,
        ]);
    
        return redirect()->route('wholesaler.index', ['product_id' => $traceabilityWholesaler->product_id])->with('success', 'Trace info added successfully.');
    }

            /**
     * Store packaging traceability data.
     */
    public function storePackagingTrace(Request $request, $product_id)
    {
        $request->validate([
            'datePackaging' => 'nullable|date',
            'latitudePackaging' => 'nullable|numeric',
            'longitudePackaging' => 'nullable|numeric',
            'addressPackaging' => 'required|string|',
        ]);

        Traceability::create([
            'product_id' => $product_id,
            'datedatePackaging' => $request->datedatePackaging,
            'latitudedatePackaging' => $request->latitudedatePackaging,
            'longitudedatePackaging' => $request->longitudedatePackaging,
            'addressdatePackaging' => $request->addressdatePackaging,
        ]);
        return redirect()->route('packaging.index', ['product_id' => $product_id])->with('success', 'Trace info added successfully.');

    }

    /**
     * Update packaging traceability data.
     */
    public function updatePackagingTrace(Request $request, $id)
    {
        $traceabilityPackaging = Traceability::find($id);

        $request->validate([
            'datePackaging' => 'nullable|date',
            'latitudePackaging' => 'nullable|numeric',
            'longitudePackaging' => 'nullable|numeric',
            'addressPackaging' => 'required|string|',
        ]);

        $traceabilityPackaging->update([
            'datePackaging' => $request->datePackaging,
            'latitudePackaging' => $request->latitudePackaging,
            'longitudePackaging' => $request->longitudePackaging,
            'addressPackaging' => $request->addressPackaging,
        ]);

        return redirect()->route('packaging.index', ['product_id' => $traceabilityPackaging->product_id])->with('success', 'Trace info added successfully.');
    }

    /**
     * Delete packaging traceability data.
     */
    public function removePackagingTrace($id)
    {
        $traceabilityPackaging = Traceability::find($id);
    
    
        $traceabilityPackaging->update([
            'latitudePackaging' => null,
            'longitudePackaging' => null,
            'datePackaging' => null,
            'addressPackaging' => null,
        ]);
    
        return redirect()->route('packaging.index', ['product_id' => $traceabilityPackaging->product_id])->with('success', 'Trace info added successfully.');
    }
    
}
