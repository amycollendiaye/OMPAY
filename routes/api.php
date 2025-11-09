<?php

use App\Http\Controllers\CompteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post("/comptes",[CompteController::class,'store']);

// Swagger Documentation Routes
Route::get('/docs', function () {
    return view('vendor.l5-swagger.index', [
        'documentation' => 'default',
        'urlToDocs' => route('l5-swagger.default.api'),
        'operationsSorter' => 'alpha',
        'configUrl' => route('l5-swagger.default.api'),
        'validatorUrl' => '',
    ]);
})->name('swagger.local');

Route::get('/docs/production', function () {
    return view('vendor.l5-swagger.index', [
        'documentation' => 'production',
        'urlToDocs' => route('l5-swagger.production.api'),
        'operationsSorter' => 'alpha',
        'configUrl' => route('l5-swagger.production.api'),
        'validatorUrl' => '',
    ]);
})->name('swagger.production');

