<?php

namespace App\Http\Controllers\Roles\Packaging;

use App\Http\Controllers\Controller;
use App\Models\Processes;
use App\Models\Products;
use App\Models\Quality;
use App\Models\Packages;
use App\Models\Markets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Traceability;
use TCPDF;

class PackagingController extends Controller
{
    public function index($product_id)
    {
        $user = Auth::user();
        
        $traceability = Traceability::getAll_2($product_id);
        $processesPackaging = Processes::where('product_id', $product_id)
        ->where('user_id', $user->id)
        ->get();        
        $qualityPackaging = Quality::where('product_id', $product_id)
        ->where('user_id', $user->id)
        ->get();        
        $honeyInfo = Products::where('id', $product_id)->latest()->first();
        $packages = Packages::where('product_id', $product_id)->get();
        $markets = Markets::where('product_id', $product_id)->get();

        return view('roles.packaging', data: compact('processesPackaging', 'qualityPackaging', 'honeyInfo', 'packages', 'markets', 'traceability'));
    }
    
    public function qrCodePackage($qrCodePackage)
    {
        $packages = Packages::where('qr_code', $qrCodePackage)->first();
        
        $value = route('consumerPackage', ['package_id' => $packages->id]);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Arvids');
        $pdf->SetTitle('Package QR Code PDF');
        $pdf->SetSubject('QR Code');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $pdf->SetFont('helvetica', '', 12);

        $pdf->Cell(0, 10, 'QR Code', 0, 1, 'C');

        $pdf->write2DBarcode($value, 'QRCODE,H', 80, 40, 50, 50, [], 'N');

        $pdf->Output('qrCodePackage.pdf', 'I');
    }

    public function storePackage(Request $request, $product_id)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'package_weight' => 'required|numeric',
            'type' => 'required|string',
            'market_id' => 'nullable|exists:markets,id',
            'is_delivered' => 'required|in:In Progress,Delivered',
        ]);
    
        $package = Packages::create([
            'quantity' => $request->quantity,
            'package_weight' => $request->package_weight,
            'type' => $request->type,
            'product_id' => $product_id,
            'market_id' => $request->market_id,
            'is_delivered' => $request->is_delivered,
        ]);

        $package->qr_code = urlencode(hash('sha256', $package->id . '-' . $package->type));
        $package->save();

        return redirect()->route('packaging.index', ['product_id' => $product_id])->with('success', 'Package added successfully.');
    }

    public function updatePackage(Request $request, $id)
    {
        $packages = Packages::findOrFail($id);
    
        $request->validate([
            'quantity' => 'required|integer',
            'package_weight' => 'required|numeric',
            'type' => 'required|string',
            'market_id' => 'nullable|exists:markets,id',
            'is_delivered' => 'required|in:In Progress,Delivered',
        ]);
    
        $packages->update([
            'quantity' => $request->quantity,
            'package_weight' => $request->package_weight,
            'type' => $request->type,
            'market_id' => $request->market_id,
            'is_delivered' => $request->is_delivered,
        ]);
    
        return redirect()->route('packaging.index', ['product_id' => $packages->product_id])->with('success', 'Package updated successfully.');
    }
    
    public function destroyPackage($id)
    {
        $packages = Packages::findOrFail($id);

        $packages->delete();
        return redirect()->route('packaging.index', ['product_id' => $packages->product_id])->with('success', 'Process info deleted successfully.');
    }
}