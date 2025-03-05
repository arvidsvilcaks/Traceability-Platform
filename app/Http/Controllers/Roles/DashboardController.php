<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Honey;
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
            case 'Packaging company':
                $query->where('packaging_id', $user->id);
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
    
        return view('dashboard', compact('honeyInfo','beekeepers','laboratoryEmployees','wholesalers','packagingCompanies'));
    }
    
    
    public function qrCode($qrCode)
    {
        $honey = Honey::where('qr_code', $qrCode)->first();

        $value = route('consumer', ['honey_id' => $honey->id]);

        // Create new PDF document
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Arvids');
        $pdf->SetTitle('QR Code PDF');
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
        $pdf->Output('qrcode.pdf', 'I');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'beekeeper_id' => 'nullable|exists:users,id',
            'laboratory_id' => 'nullable|exists:users,id',
            'wholesaler_id' => 'nullable|exists:users,id',
            'packaging_id' => 'nullable|exists:users,id'
        ]);
    
        $beekeeper_id = $request->beekeeper_id ?: null;
        $laboratory_id = $request->laboratory_id ?: null;
        $wholesaler_id = $request->wholesaler_id ?: null;
        $packaging_id = $request->packaging_id ?: null;

        $product = Honey::create([
            'name' => $request->input('name'),
            'beekeeper_id' => $beekeeper_id,
            'laboratory_id' => $laboratory_id,
            'wholesaler_id' => $wholesaler_id,
            'packaging_id' => $packaging_id,
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
}
