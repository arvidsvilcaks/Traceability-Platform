<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Roles\DashboardController;
use App\Http\Controllers\Roles\Beekeeper\BeekeeperController;
use App\Http\Controllers\Roles\Beekeeper\ApiaryController;
use App\Http\Controllers\Roles\Beekeeper\BeeDocumentController;
use App\Http\Controllers\Roles\Beekeeper\ProductController;
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


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/consumer/{product_id}', function () {
    return view('roles.consumer');
})->name('consumer');

Route::get('/disabled-account', function () {
    return view('auth.disabled');
});

Route::get('/qr_code/{qr_code?}', [DashboardController::class, 'qrCode'])->name('qr_code');

Route::middleware(['auth', 'verified', 'enabled'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/dashboard/store', [DashboardController::class, 'store'])->name('dashboard.store');
    Route::put('/dashboard/update/{id}', [DashboardController::class, 'update'])->name('dashboard.update');
    Route::delete('/dashboard/delete/{id}', [DashboardController::class, 'delete'])->name('dashboard.delete');    

    Route::patch('/users/update-status/{user}', [UserController::class, 'updateStatus'])->name('users.update_status');

    Route::get('/administrator', [UserController::class, 'indexAdministrator'])->middleware('role:Administrator')->name('administrator.indexAdministrator');

    Route::get('/association', [UserController::class, 'indexAssociation'])->middleware('role:Beekeeping association')->name('association.indexAssociation');
    
    Route::get('/beekeeper/{product_id?}', [BeekeeperController::class, 'index'])->middleware('role:Beekeeper')->name('beekeeper.index');

    Route::post('/beekeeper/storeApiary/{product_id}', [ApiaryController::class, 'storeApiary'])->middleware('role:Beekeeper')->name('apiary.storeApiary');
    Route::put('/beekeeper/updateApiary/{id}', [ApiaryController::class, 'updateApiary'])->middleware('role:Beekeeper')->name('apiary.updateApiary');
    Route::delete('/beekeeper/destroyApiary/{id}', [ApiaryController::class, 'destroyApiary'])->middleware('role:Beekeeper')->name('apiary.destroyApiary');

    Route::post('/beekeeper/addDocument/{product_id}', [BeeDocumentController::class, 'addDocument'])->name('beekeepingDocuments.addDocument');
    Route::put('/beekeeper/updateDocument/{id}', [BeeDocumentController::class, 'updateDocument'])->name('beekeepingDocuments.updateDocument');
    Route::delete('/beekeeper/deleteDocument/{id}', [BeeDocumentController::class, 'deleteDocument'])->name('beekeepingDocuments.deleteDocument');
    
    Route::post('/beekeeper/addProduct', [ProductController::class, 'addProduct'])->name('products.addProduct');
    Route::put('/beekeeper/updateProduct/{id}', [ProductController::class, 'updateProduct'])->name('products.updateProduct');
    Route::delete('/beekeeper/deleteProduct/{id}', [ProductController::class, 'deleteProduct'])->name('products.deleteProduct');

    Route::get('/laboratory/{product_id?}', [LaboratoryController::class, 'index'])->middleware('role:Laboratory employee')->name('laboratory.index');
    
    Route::post('/laboratory/storeAnalysis', [AnalysisController::class, 'storeAnalysis'])->name('analysis.storeAnalysis');
    Route::put('/laboratory/updateAnalysis/{id}', [AnalysisController::class, 'updateAnalysis'])->name('analysis.updateAnalysis');
    Route::delete('/laboratory/deleteAnalysis/{id}', [AnalysisController::class, 'deleteAnalysis'])->name('analysis.deleteAnalysis');

    Route::get('/wholesaler/{product_id?}', [WholesalerController::class, 'index'])->middleware('role:Wholesaler')->name('wholesaler.index');

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
