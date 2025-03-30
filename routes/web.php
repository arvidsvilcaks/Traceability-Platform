<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Roles\DashboardController;
use App\Http\Controllers\Roles\TraceabilityController;
use App\Http\Controllers\Roles\Beekeeper\BeekeeperController;
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
use App\Http\Controllers\Roles\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/disabled-account', function () {
    return view('auth.disabled');
});

Route::get('/qr_code_Honey/{qr_code?}', [DashboardController::class, 'qrCodeHoney'])->name('qr_code_Honey');
Route::get('/qr_code_Product/{qr_code?}', [DashboardController::class, 'qrCodeProduct'])->name('qr_code_Product');
Route::get('/qr_code_Package/{qr_code?}', [PackagingController::class, 'qrCodePackage'])->name('qr_code_Package');

Route::get('/consumerPackage/{package_id}', [TraceabilityController::class, 'indexPackage'])->name('consumerPackage');

Route::middleware(['auth', 'verified', 'enabled'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::patch('/users/update-status/{user}', [UserController::class, 'updateStatus'])->name('users.update_status');

    Route::get('/administrator', [UserController::class, 'indexAdministrator'])->middleware('role:Administrator')->name('administrator.indexAdministrator');

    Route::get('/association', [UserController::class, 'indexAssociation'])->middleware('role:Beekeeping association')->name('association.indexAssociation');

    Route::get('/consumerHoney/{honey_id}', [TraceabilityController::class, 'indexHoney'])->name('consumerHoney');
    Route::get('/consumerProduct/{product_id}', [TraceabilityController::class, 'indexProduct'])->name('consumerProduct');

    Route::post('/dashboard/storeHoney/', [DashboardController::class, 'storeHoney'])->name('dashboard.storeHoney');
    Route::put('/dashboard/updateHoney/{id}', [DashboardController::class, 'updateHoney'])->name('dashboard.updateHoney');
    Route::delete('/dashboard/destroyHoney/{id}', [DashboardController::class, 'destroyHoney'])->name('dashboard.destroyHoney');    
    Route::delete('/dashboard/destroyVisualMaterial/{id}', [DashboardController::class, 'destroyVisualMaterial'])->name('dashboard.destroyVisualMaterial');    
    Route::post('/dashboard/product/storeProduct', [DashboardController::class, 'storeProduct'])->name('dashboard.product.storeProduct');
    Route::put('/dashboard/product/updateProduct/{id}', [DashboardController::class, 'updateProduct'])->name('dashboard.product.updateProduct');
    Route::delete('/dashboard/product/destroyProduct/{id}', [DashboardController::class, 'destroyProduct'])->name('dashboard.product.destroyProduct');
    Route::post('/dashboard/storeApiary/', [DashboardController::class, 'storeApiary'])->middleware('role:Beekeeper')->name('dashboard.storeApiary');
    Route::put('/dashboard/updateApiary/{id}', [DashboardController::class, 'updateApiary'])->middleware('role:Beekeeper')->name('dashboard.updateApiary');
    Route::delete('/dashboard/destroyApiary/{id}', [DashboardController::class, 'destroyApiary'])->middleware('role:Beekeeper')->name('dashboard.destroyApiary');

    Route::get('/beekeeper/{honey_id?}', [BeekeeperController::class, 'index'])->middleware('role:Beekeeper')->name('beekeeper.index');
    Route::post('/beekeeper/assignLaboratoryAndWholesaler', [BeekeeperController::class, 'assignLaboratoryAndWholesaler'])->name('beekeeper.assignLaboratoryAndWholesaler');
    Route::post('/beekeeper/storeDocument/{honey_id}', [BeeDocumentController::class, 'storeDocument'])->name('beekeepingDocuments.storeDocument');
    Route::put('/beekeeper/updateDocument/{id}', [BeeDocumentController::class, 'updateDocument'])->name('beekeepingDocuments.updateDocument');
    Route::delete('/beekeeper/destroyDocument/{id}', [BeeDocumentController::class, 'destroyDocument'])->name('beekeepingDocuments.destroyDocument');
    Route::post('/beekeeper/storeHoneyInfo', [HoneyController::class, 'storeHoneyInfo'])->name('honey.storeHoneyInfo');
    Route::put('/beekeeper/updateHoneyInfo/{id}', [HoneyController::class, 'updateHoneyInfo'])->name('honey.updateHoneyInfo');
    Route::delete('/beekeeper/destroyHoneyInfo/{id}', [HoneyController::class, 'destroyHoneyInfo'])->name('honey.destroyHoneyInfo');

    Route::get('/laboratory/{honey_id?}', [LaboratoryController::class, 'index'])->middleware('role:Laboratory employee')->name('laboratory.index');
    Route::post('/laboratory/storeAnalysis', [AnalysisController::class, 'storeAnalysis'])->name('analysis.storeAnalysis');
    Route::put('/laboratory/updateAnalysis/{id}', [AnalysisController::class, 'updateAnalysis'])->name('analysis.updateAnalysis');
    Route::delete('/laboratory/destroyAnalysis/{id}', [AnalysisController::class, 'destroyAnalysis'])->name('analysis.destroyAnalysis');

    Route::get('/wholesaler/{product_id?}', [WholesalerController::class, 'index'])->middleware('role:Wholesaler')->name('wholesaler.index');
    Route::post('/wholesaler/assignPackaging', [WholesalerController::class, 'assignPackaging'])->name('wholesaler.assignPackaging');
    Route::post('/wholesaler/storeProcess/{product_id}', [ProcessWholesalerController::class, 'storeProcess'])->name('processesWholesaler.storeProcess');
    Route::put('/wholesaler/updateProcess/{id}', [ProcessWholesalerController::class, 'updateProcess'])->name('processesWholesaler.updateProcess');
    Route::delete('/wholesaler/destroyProcess/{id}', [ProcessWholesalerController::class, 'destroyProcess'])->name('processesWholesaler.destroyProcess');
    Route::delete('/wholesaler/destroyVisualMaterial/{id}', [ProcessWholesalerController::class, 'destroyVisualMaterial'])->name('processesWholesaler.destroyVisualMaterial');
    Route::post('/wholesaler/storeQuality/{product_id}', [QualityWholesalerController::class, 'storeQuality'])->name('qualityWholesaler.storeQuality');
    Route::put('/wholesaler/updateQuality/{id}', [QualityWholesalerController::class, 'updateQuality'])->name('qualityWholesaler.updateQuality');
    Route::delete('/wholesaler/destroyQuality/{id}', [QualityWholesalerController::class, 'destroyQuality'])->name('qualityWholesaler.destroyQuality');
    Route::post('/wholesaler/storeMarket/{product_id}', [MarketController::class, 'storeMarket'])->name('market.storeMarket');
    Route::put('/wholesaler/updateMarket/{id}', [MarketController::class, 'updateMarket'])->name('market.updateMarket');
    Route::delete('/wholesaler/destroyMarket/{id}', [MarketController::class, 'destroyMarket'])->name('market.destroyMarket');

    Route::get('/packaging/{product_id?}', [PackagingController::class, 'index'])->middleware('role:Packaging company')->name('packaging.index');
    Route::post('/packaging/storeProcess/{product_id}', [ProcessPackagingController::class, 'storeProcess'])->name('processesPackaging.storeProcess');
    Route::put('/packaging/updateProcess/{id}', [ProcessPackagingController::class, 'updateProcess'])->name('processesPackaging.updateProcess');
    Route::delete('/packaging/destroyProcess/{id}', [ProcessPackagingController::class, 'destroyProcess'])->name('processesPackaging.destroyProcess');
    Route::delete('/packaging/destroyVisualMaterial/{id}', [ProcessPackagingController::class, 'destroyVisualMaterial'])->name('processesPackaging.destroyVisualMaterial');
    Route::post('/packaging/storeQuality/{product_id}', [QualityPackagingController::class, 'storeQuality'])->name('qualityPackaging.storeQuality');
    Route::put('/packaging/updateQuality/{id}', [QualityPackagingController::class, 'updateQuality'])->name('qualityPackaging.updateQuality');
    Route::delete('/packaging/destroyQuality/{id}', [QualityPackagingController::class, 'destroyQuality'])->name('qualityPackaging.destroyQuality');
    Route::post('/packaging/storeProductPackages/{product_id}', [PackagingController::class, 'storePackage'])->name('packages.storePackage');
    Route::put('/packaging/updateProductPackages/{id}', [PackagingController::class, 'updatePackage'])->name('packages.updatePackage');
    Route::delete('/packaging/destroyProductPackages/{id}', [PackagingController::class, 'destroyPackage'])->name('packages.destroyPackage');

    Route::post('/traceabilityHoney/{honey_id}', [BeekeeperController::class, 'storeTraceabilityHoney'])->name('traceability.storeTraceabilityHoney');
    Route::put('/traceabilityHoney/{id}', [BeekeeperController::class, 'updateTraceabilityHoney'])->name('traceability.updateTraceabilityHoney');
    Route::delete('/traceabilityHoney/{id}', [BeekeeperController::class, 'destroyTraceabilityHoney'])->name('traceability.destroyTraceabilityHoney');
    Route::post('/traceabilityProduct/{product_id}', [WholesalerController::class, 'storeTraceabilityProduct'])->name('traceability.storeTraceabilityProduct');
    Route::put('/traceabilityProduct/{id}', [WholesalerController::class, 'updateTraceabilityProduct'])->name('traceability.updateTraceabilityProduct');
    Route::delete('/traceabilityProduct/{id}', [WholesalerController::class, 'destroyTraceabilityProduct'])->name('traceability.destroyTraceabilityProduct');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
