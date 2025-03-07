<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Roles\DashboardController;
use App\Http\Controllers\Roles\Beekeeper\BeekeeperController;
use App\Http\Controllers\Roles\Beekeeper\ApiaryController;
use App\Http\Controllers\Roles\Beekeeper\BeeDocumentController;
use App\Http\Controllers\Roles\Beekeeper\HoneyController;
use App\Http\Controllers\Roles\Laboratory\LaboratoryController;
use App\Http\Controllers\Roles\Laboratory\AnalysisController;
use App\Http\Controllers\Roles\Wholesaler\WholesalerController;
use App\Http\Controllers\Roles\Wholesaler\ProcessWholesalerController;
use App\Http\Controllers\Roles\Wholesaler\QualityWholesalerController;
use App\Http\Controllers\Roles\Wholesaler\MarketController;
use App\Http\Controllers\Roles\Packaging\PackagingController;
use App\Http\Controllers\Roles\Packaging\ProcessPackagingController;
use App\Http\Controllers\Roles\Packaging\QualityPackagingController;
use App\Http\Controllers\Roles\TraceabilityController;
use App\Http\Controllers\Roles\UserController;
use App\Http\Controllers\MapController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/map', [MapController::class, 'index']);

Route::get('/consumerHoney/{honey_id}', function () {
    return view('roles.consumerHoney');
})->name('consumerHoney');

Route::get('/consumerProduct/{product_id}', function () {
    return view('roles.consumerProduct');
})->name('consumerProduct');

Route::get('/disabled-account', function () {
    return view('auth.disabled');
});

Route::get('/qr_code_Honey/{qr_code?}', [DashboardController::class, 'qrCodeHoney'])->name('qr_code_Honey');

Route::get('/qr_code_Product/{qr_code?}', [DashboardController::class, 'qrCodeProduct'])->name('qr_code_Product');

Route::middleware(['auth', 'verified', 'enabled'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/dashboard/store', [DashboardController::class, 'store'])->name('dashboard.store');
    Route::put('/dashboard/update/{id}', [DashboardController::class, 'update'])->name('dashboard.update');
    Route::delete('/dashboard/delete/{id}', [DashboardController::class, 'delete'])->name('dashboard.delete');    

    Route::post('/dashboard/product/storeProduct', [DashboardController::class, 'storeProduct'])->name('dashboard.product.storeProduct');
    Route::put('/dashboard/product/updateProduct/{id}', [DashboardController::class, 'updateProduct'])->name('dashboard.product.updateProduct');
    Route::delete('/dashboard/product/deleteProduct/{id}', [DashboardController::class, 'deleteProduct'])->name('dashboard.product.deleteProduct');

    Route::patch('/users/update-status/{user}', [UserController::class, 'updateStatus'])->name('users.update_status');

    Route::get('/administrator', [UserController::class, 'indexAdministrator'])->middleware('role:Administrator')->name('administrator.indexAdministrator');

    Route::get('/association', [UserController::class, 'indexAssociation'])->middleware('role:Beekeeping association')->name('association.indexAssociation');
    
    Route::get('/beekeeper/{honey_id?}', [BeekeeperController::class, 'index'])->middleware('role:Beekeeper')->name('beekeeper.index');
    Route::post('/beekeeper/update', [BeekeeperController::class, 'update'])->name('beekeeper.update');

    Route::post('/beekeeper/storeApiary/{honey_id}', [ApiaryController::class, 'storeApiary'])->middleware('role:Beekeeper')->name('apiary.storeApiary');
    Route::put('/beekeeper/updateApiary/{id}', [ApiaryController::class, 'updateApiary'])->middleware('role:Beekeeper')->name('apiary.updateApiary');
    Route::delete('/beekeeper/destroyApiary/{id}', [ApiaryController::class, 'destroyApiary'])->middleware('role:Beekeeper')->name('apiary.destroyApiary');

    Route::post('/beekeeper/addDocument/{honey_id}', [BeeDocumentController::class, 'addDocument'])->name('beekeepingDocuments.addDocument');
    Route::put('/beekeeper/updateDocument/{id}', [BeeDocumentController::class, 'updateDocument'])->name('beekeepingDocuments.updateDocument');
    Route::delete('/beekeeper/deleteDocument/{id}', [BeeDocumentController::class, 'deleteDocument'])->name('beekeepingDocuments.deleteDocument');
    
    Route::post('/beekeeper/addHoney', [HoneyController::class, 'addHoney'])->name('honey.addHoney');
    Route::put('/beekeeper/updateHoney/{id}', [HoneyController::class, 'updateHoney'])->name('honey.updateHoney');
    Route::delete('/beekeeper/deleteHoney/{id}', [HoneyController::class, 'deleteHoney'])->name('honey.deleteHoney');

    Route::get('/laboratory/{honey_id?}', [LaboratoryController::class, 'index'])->middleware('role:Laboratory employee')->name('laboratory.index');
    
    Route::post('/laboratory/storeAnalysis', [AnalysisController::class, 'storeAnalysis'])->name('analysis.storeAnalysis');
    Route::put('/laboratory/updateAnalysis/{id}', [AnalysisController::class, 'updateAnalysis'])->name('analysis.updateAnalysis');
    Route::delete('/laboratory/deleteAnalysis/{id}', [AnalysisController::class, 'deleteAnalysis'])->name('analysis.deleteAnalysis');

    Route::get('/wholesaler/{product_id?}', [WholesalerController::class, 'index'])->middleware('role:Wholesaler')->name('wholesaler.index');
    Route::post('/wholesaler/update', [WholesalerController::class, 'update'])->name('wholesaler.update');

    Route::post('/wholesaler/storeProcess/{product_id}', [ProcessWholesalerController::class, 'storeProcess'])->name('processesWholesaler.storeProcess');
    Route::put('/wholesaler/updateProcess/{id}', [ProcessWholesalerController::class, 'updateProcess'])->name('processesWholesaler.updateProcess');
    Route::delete('/wholesaler/destroyProcess/{id}', [ProcessWholesalerController::class, 'destroyProcess'])->name('processesWholesaler.destroyProcess');

    Route::post('/wholesaler/storeHoneyQuality/{product_id}', [QualityWholesalerController::class, 'storeHoneyQuality'])->name('qualityWholesaler.storeHoneyQuality');
    Route::put('/wholesaler/updateHoneyQuality/{id}', [QualityWholesalerController::class, 'updateHoneyQuality'])->name('qualityWholesaler.updateHoneyQuality');
    Route::delete('/wholesaler/destroyHoneyQuality/{id}', [QualityWholesalerController::class, 'destroyHoneyQuality'])->name('qualityWholesaler.destroyHoneyQuality');

    Route::post('/wholesaler/storeMarket/{product_id}', [MarketController::class, 'storeMarket'])->name('market.storeMarket');
    Route::put('/wholesaler/updateMarket/{id}', [MarketController::class, 'updateMarket'])->name('market.updateMarket');
    Route::delete('/wholesaler/destroyMarket/{id}', [MarketController::class, 'destroyMarket'])->name('market.destroyMarket');

    Route::get('/packaging/{product_id?}', [PackagingController::class, 'index'])->middleware('role:Packaging company')->name('packaging.index');

    Route::post('/packaging/storeProcess/{product_id}', [ProcessPackagingController::class, 'storeProcess'])->name('processesPackaging.storeProcess');
    Route::put('/packaging/updateProcess/{id}', [ProcessPackagingController::class, 'updateProcess'])->name('processesPackaging.updateProcess');
    Route::delete('/packaging/destroyProcess/{id}', [ProcessPackagingController::class, 'destroyProcess'])->name('processesPackaging.destroyProcess');

    Route::post('/packaging/storeHoneyQuality/{product_id}', [QualityPackagingController::class, 'storeHoneyQuality'])->name('qualityPackaging.storeHoneyQuality');
    Route::put('/packaging/updateHoneyQuality/{id}', [QualityPackagingController::class, 'updateHoneyQuality'])->name('qualityPackaging.updateHoneyQuality');
    Route::delete('/packaging/destroyHoneyQuality/{id}', [QualityPackagingController::class, 'destroyHoneyQuality'])->name('qualityPackaging.destroyHoneyQuality');

    Route::post('/packaging/storeProductPackages/{product_id}', [PackagingController::class, 'storePackage'])->name('packages.storePackage');
    Route::put('/packaging/updateProductPackages/{id}', [PackagingController::class, 'updatePackage'])->name('packages.updatePackage');
    Route::delete('/packaging/destroyProductPackages/{id}', [PackagingController::class, 'destroyPackage'])->name('packages.destroyPackage');

    Route::post('/laboratory/storeLaboratoryTrace/{product_id}', [TraceabilityController::class, 'storeLaboratoryTrace'])->name('traceabilityLaboratory.storeLaboratoryTrace');
    Route::put('/laboratory/updateLaboratoryTrace/{id}', [TraceabilityController::class, 'updateLaboratoryTrace'])->name('traceabilityLaboratory.updateLaboratoryTrace');
    Route::delete('/laboratory/removeLaboratoryTrace/{id}', [TraceabilityController::class, 'removeLaboratoryTrace'])->name('traceabilityLaboratory.removeLaboratoryTrace');

    Route::post('/wholesaler/storeWholesalerTrace/{product_id}', [TraceabilityController::class, 'storeWholesalerTrace'])->name('traceabilityWholesaler.storeWholesalerTrace');
    Route::put('/wholesaler/updateWholesalerTrace/{id}', [TraceabilityController::class, 'updateWholesalerTrace'])->name('traceabilityWholesaler.updateWholesalerTrace');
    Route::delete('/wholesaler/removeWholesalerTrace/{id}', [TraceabilityController::class, 'removeWholesalerTrace'])->name('traceabilityWholesaler.removeWholesalerTrace');

    Route::post('/packaging/storePackagingTrace/{product_id}', [TraceabilityController::class, 'storePackagingTrace'])->name('traceabilityPackaging.storePackagingTrace');
    Route::put('/packaging/updatePackagingTrace/{id}', [TraceabilityController::class, 'updatePackagingTrace'])->name('traceabilityPackaging.updatePackagingTrace');
    Route::delete('/packaging/removePackagingTrace/{id}', [TraceabilityController::class, 'removePackagingTrace'])->name('traceabilityPackaging.removePackagingTrace');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
