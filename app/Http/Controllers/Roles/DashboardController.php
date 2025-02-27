<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use TCPDF;

class DashboardController extends Controller
{
    public function index()
    {
        $honeyInfo = Products::all();
        return view('dashboard', compact('honeyInfo'));
    }
    public function qrCode($qrCode)
    {
        $product = Products::where('qr_code', $qrCode)->first();

        $value = route('consumer', ['product_id' => $product->id]);

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
            'name' => 'required|string|'
        ]);

        $product = Products::create([
            'name' => $request->input('name')
        ]);

        $product->qr_code = urlencode(hash('sha256', $product->id . '-' . $product->name));
        $product->save();

        return redirect()->route('dashboard')->with('success', 'Product added successfully!');
    }

}
