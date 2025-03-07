<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Honey;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use TCPDF;

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
    
        $wholesalerId = auth()->id();
        $packagingId = auth()->id();
        $honeys = Honey::where('wholesaler_id', $wholesalerId)->get(); 
        $products = Products::where('wholesaler_id', $wholesalerId) 
            ->orWhere('packaging_id', $packagingId)
            ->with('honeys')
            ->get();
    
        return view('dashboard', compact('honeyInfo','beekeepers','laboratoryEmployees','wholesalers','packagingCompanies', 'products', 'honeys'));
    }
    
    
    public function qrCodeHoney($qrCodeHoney)
    {
        $honey = Honey::where('qr_code', $qrCodeHoney)->first();

        $value = route('consumerHoney', ['honey_id' => $honey->id]);

        // Create new PDF document
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Arvids');
        $pdf->SetTitle('Honey QR Code PDF');
        $pdf->SetSubject('QR Code');

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Add Title
        $pdf->Cell(0, 10, 'QR Code', 0, 1, 'C');

        // Generate and embed QR Code
        $pdf->write2DBarcode($value, 'QRCODE,H', 80, 40, 50, 50, [], 'N');

        // Output the PDF in browser
        $pdf->Output('qrCodeHoney.pdf', 'I');
    }

    public function qrCodeProduct($qrCodeProduct)
    {
        $products = Products::where('qr_code', $qrCodeProduct)->first();

        $value = route('consumerProduct', ['product_id' => $products->id]);

        // Create new PDF document
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Arvids');
        $pdf->SetTitle('Product QR Code PDF');
        $pdf->SetSubject('QR Code');

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Add Title
        $pdf->Cell(0, 10, 'QR Code', 0, 1, 'C');

        // Generate and embed QR Code
        $pdf->write2DBarcode($value, 'QRCODE,H', 80, 40, 50, 50, [], 'N');

        // Output the PDF in browser
        $pdf->Output('qrCodeProduct.pdf', 'I');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'beekeeper_id' => 'nullable|exists:users,id',
            'laboratory_id' => 'nullable|exists:users,id',
            'wholesaler_id' => 'nullable|exists:users,id'
        ]);
    
        $beekeeper_id = $request->beekeeper_id ?: null;
        $laboratory_id = $request->laboratory_id ?: null;
        $wholesaler_id = $request->wholesaler_id ?: null;

        $product = Honey::create([
            'name' => $request->input('name'),
            'beekeeper_id' => $beekeeper_id,
            'laboratory_id' => $laboratory_id,
            'wholesaler_id' => $wholesaler_id,
        ]);
    
        $product->qr_code = urlencode(hash('sha256', $product->id . '-' . $product->name));
        $product->save();
    
        return redirect()->route('dashboard')->with('success', 'Product added successfully!');
    }
    public function update(Request $request, $id)
    {
        $product = Honey::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
        ]);

        $product->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Product info updated successfully');
    }

    public function delete($id)
    {
        $product = Honey::findOrFail($id);

        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Product added successfully!');
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $product = Products::findOrFail($id);

        $product->name = $request->input('name');
        $product->save();

        return redirect()->route('dashboard')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct($id)
    {
        $product = Products::findOrFail($id);

        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Product added successfully!');
    }
}