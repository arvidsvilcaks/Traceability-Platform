<?php

namespace App\Http\Controllers\Roles\Beekeeper;

use App\Http\Controllers\Controller;
use App\Models\Apiary;
use App\Models\Honey;
use App\Models\BeekeepingDocuments;
use App\Models\Traceability;
use App\Models\User;
use Illuminate\Http\Request;

class BeekeeperController extends Controller
{
    public function index($honey_id)
    {
        $honeyInfo = Honey::where('id', $honey_id)->first();
        $beekeepingDocuments = BeekeepingDocuments::where('honey_id', $honey_id)->get();
        $apiary = Apiary::where('honey_id', $honey_id)->get();
        $traceability = Traceability::getAll($honey_id);
        $user = auth()->user();
    
        $laboratoryEmployees = User::where('role', 'Laboratory employee')->get();
        $wholesalers = User::where('role', 'Wholesaler')->get();
    
        $query = Honey::query();
    
        switch ($user->role) {
            case 'Laboratory employee':
                $query->where('laboratory_id', $user->id);
                break;
            case 'Wholesaler':
                $query->where('wholesaler_id', $user->id);
                break;
            default:
                $query->whereNull('id');
                break;
        }
    
        $honey = $query->get();
        return view('roles.beekeeper', compact('apiary', 'beekeepingDocuments', 'honeyInfo', 'traceability', 'laboratoryEmployees', 'wholesalers', 'honey'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'honey_id' => 'required|exists:honey,id',
            'laboratory_id' => 'nullable|exists:users,id',
            'wholesaler_id' => 'nullable|exists:users,id',
        ]);
    
        $honey = Honey::findOrFail($request->honey_id);
    
        if ($request->has('laboratory_id')) {
            $honey->laboratory_id = $request->laboratory_id ?: null;
        }
        if ($request->has('wholesaler_id')) {
            $honey->wholesaler_id = $request->wholesaler_id ?: null;
        }
    
        $honey->save();
    
        return redirect()->back()->with('success', 'Product info updated successfully');
    }
    // Store new traceability record
    public function storeTraceability(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'stage' => 'required|in:laboratory,wholesaler,packaging'
        ]);

        Traceability::create($request->all());

        return redirect()->back()->with('success', 'Traceability record added successfully.');
    }
    
    // Update traceability record
    public function updateTraceability(Request $request, $id)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'stage' => 'required|in:laboratory,wholesaler,packaging'
        ]);

        $traceability = Traceability::findOrFail($id);
        $traceability->update($request->all());

        return redirect()->back()->with('success', 'Traceability record updated successfully.');
    }
    
    // Delete traceability record
    public function destroyTraceability($id)
    {
        Traceability::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Traceability record deleted successfully.');
    }
}
