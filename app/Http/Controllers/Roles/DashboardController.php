<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Honey;
use App\Models\Products;
use App\Models\User;
use App\Models\Apiary;
use Illuminate\Http\Request;
use TCPDF;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        $beekeepers = User::where('role', 'Beekeeper')->get();
        $laboratoryEmployees = User::where('role', 'Laboratory employee')->get();
        $wholesalers = User::where('role', 'Wholesaler')->get();
        $packagingCompanies = User::where('role', 'Packaging company')->get();
    
        $query = Honey::query();
        switch ($user->role) {
            case 'Beekeeper':
                $query->where('beekeeper_id', $user->id);
                break;
            case 'Laboratory employee':
                $query->where('laboratory_id', $user->id);
                break;
            case 'Wholesaler':
                $query->where('wholesaler_id', $user->id);
                break;
            case 'Beekeeping association':
                break;
            case 'Administrator':
                break;
            default:
                $query->whereNull('id');
                break;
        }
    
        $honeyInfo = $query->get();
        $apiaryInfo = Apiary::where('beekeeper_id', $user->id)->get();

        $wholesalerId = auth()->id();
        $packagingId = auth()->id();
        $honeys = Honey::where('wholesaler_id', $wholesalerId)->get(); 
        $products = Products::where('wholesaler_id', $wholesalerId) 
            ->orWhere('packaging_id', $packagingId)
            ->with('honeys')
            ->get();
    
        return view('dashboard', compact('honeyInfo','apiaryInfo','beekeepers','laboratoryEmployees','wholesalers','packagingCompanies', 'products', 'honeys'));
    }
    public function qrCodeHoney($qrCodeHoney)
    {
        $honey = Honey::where('qr_code', $qrCodeHoney)->first();

        $value = route('consumerHoney', ['honey_id' => $honey->id]);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Arvids');
        $pdf->SetTitle('Honey QR Code PDF');
        $pdf->SetSubject('QR Code');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $pdf->SetFont('helvetica', '', 12);

        $pdf->Cell(0, 10, 'QR Code', 0, 1, 'C');

        $pdf->write2DBarcode($value, 'QRCODE,H', 80, 40, 50, 50, [], 'N');

        $pdf->Output('qrCodeHoney.pdf', 'I');
    }

    public function qrCodeProduct($qrCodeProduct)
    {
        $products = Products::where('qr_code', $qrCodeProduct)->first();

        $value = route('consumerProduct', ['product_id' => $products->id]);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Arvids');
        $pdf->SetTitle('Product QR Code PDF');
        $pdf->SetSubject('QR Code');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $pdf->SetFont('helvetica', '', 12);

        $pdf->Cell(0, 10, 'QR Code', 0, 1, 'C');

        $pdf->write2DBarcode($value, 'QRCODE,H', 80, 40, 50, 50, [], 'N');

        $pdf->Output('qrCodeProduct.pdf', 'I');
    }

    public function storeApiary(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'location' => 'required|string',
            'floral_composition' => 'required|string',
            'hives_count' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'specifics_of_environment' => 'required|string',
            'add_visual_materials' => 'nullable|mimes:pdf,docx,jpg,png,jpeg|max:2048',
            'beekeeper_id' => 'nullable|exists:users,id',
        ]);

        $beekeeper_id = $request->beekeeper_id ?: null;

        $filePath = null;
        if ($request->hasFile('add_visual_materials')) {
            $filePath = $request->file('add_visual_materials')->store('apiary_files', 'public');
        }

        Apiary::create([
            'description' => $request->description,
            'location' => $request->location,
            'floral_composition' => $request->floral_composition,
            'specifics_of_environment' => $request->specifics_of_environment,
            'hives_count' => $request->hives_count,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'add_visual_materials' => $filePath,
            'beekeeper_id' => $beekeeper_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Apiary added successfully!');
    }

    public function updateApiary(Request $request, $id)
    {
        $apiary = Apiary::findOrFail($id);

        $request->validate([
            'description' => 'required|string',
            'location' => 'required|string',
            'floral_composition' => 'required|string',
            'specifics_of_environment' => 'required|string',
            'hives_count' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'add_visual_materials' => 'nullable|mimes:pdf,docx,jpg,png,jpeg|max:2048'
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
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'floral_composition' => $request->floral_composition,
            'specifics_of_environment' => $request->specifics_of_environment,
            'hives_count' => $request->hives_count
        ]);

        return redirect()->route('dashboard')->with('success', 'Apiary added successfully!');

    }

    public function destroyApiary($id)
    {
        Honey::where('apiary_id', $id)->update(['apiary_id' => null]);

        $apiary = Apiary::findOrFail($id);

        if ($apiary->add_visual_materials) {
            Storage::disk('public')->delete($apiary->add_visual_materials);
        }

        $apiary->delete();
        return redirect()->route('dashboard')->with('success', 'Apiary added successfully!');

    }
    
    public function storeHoney(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'beekeeper_id' => 'nullable|exists:users,id',
            'laboratory_id' => 'nullable|exists:users,id',
            'wholesaler_id' => 'nullable|exists:users,id',
            'apiary_id' => 'nullable|exists:apiary,id'
        ]);
    
        $beekeeper_id = $request->beekeeper_id ?: null;
        $laboratory_id = $request->laboratory_id ?: null;
        $wholesaler_id = $request->wholesaler_id ?: null;

        $product = Honey::create([
            'name' => $request->input('name'),
            'beekeeper_id' => $beekeeper_id,
            'laboratory_id' => $laboratory_id,
            'wholesaler_id' => $wholesaler_id,
            'apiary_id' => $request->apiary_id
        ]);
    
        $product->qr_code = urlencode(hash('sha256', $product->id . '-' . $product->name));
        $product->save();
    
        return redirect()->route('dashboard')->with('success', 'Product added successfully!');
    }
    public function updateHoney(Request $request, $id)
    {
        $product = Honey::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string',
            'apiary_id' => 'nullable|exists:apiary,id'
        ]);
    
        $product->update([
            'name' => $request->name,
            'apiary_id' => $request->apiary_id
        ]);
    
        return redirect()->route('dashboard', ['apiary_id' => $product->apiary_id])
            ->with('success', 'Product updated successfully!');
    }
    

    public function destroyHoney($id)
    {
        $product = Honey::findOrFail($id);

        $product->delete();

        return redirect()->route('dashboard', ['apiary_id' => $product->apiary_id])
            ->with('success', 'Product updated successfully!');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'honey_ids' => 'required|array',
            'honey_ids.*' => 'exists:honey,id',
            'wholesaler_id' => 'nullable|exists:users,id',
        ]);

        $wholesaler_id = $request->wholesaler_id ?: null;

        $product = Products::create([
            'name' => $request->name,
            'wholesaler_id' => $wholesaler_id,
        ]);

        $product->honeys()->attach($request->honey_ids);
        $product->qr_code = urlencode(hash('sha256', $product->id . '-' . $product->name));
        $product->save();

        Honey::whereIn('id', $request->honey_ids)->update(['is_available' => false]);
        
        return redirect()->route('dashboard')->with('success', 'Product created successfully!');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $product->update([
            'name' => $request->name,
        ]);

        $product->update();

        return redirect()->route('dashboard')->with('success', 'Product updated successfully.');
    }

    public function destroyProduct($id)
    {
        $product = Products::findOrFail($id);

        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Product added successfully!');
    }
}