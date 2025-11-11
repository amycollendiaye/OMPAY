<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionPayementControlle;
use App\Http\Controllers\TransactionTransfertController;
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

// Routes d'authentification
Route::post('/auth', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('/profile', [AuthController::class, 'profile']);

// Routes des comptes
Route::post("/comptes",[CompteController::class,'store']);
Route::middleware('auth:api')->group(function () {
    // Liste des transactions du client connecté
    Route::get('transactions', [TransactionController::class, 'index']);

    // Transfert entre comptes
    Route::post('transactions/transfer', [TransactionTransfertController::class, 'transfert']);

    // Paiement vers un client ou distributeur
    Route::post('transactions/pay', [TransactionPayementControlle::class, 'paiement']);
});

