<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Services\TransactionTransfertService;
use Illuminate\Http\Request;

class TransactionTransfertController extends Controller
{
    
    protected $transfertService;
    public  function  __construct(TransactionTransfertService $transfertService)
    {
        $this->transfertService = $transfertService;
    }
    public function transfert(Request $request)
    {
        $request->validate([
            'destinataire_telephone' => 'required',
            'montant' => 'required|numeric|min:1',
        ]);

        $emetteur = auth()->user()->compte;
        $recepteur = Compte::whereHas(
            'client',
            fn($q) =>
            $q->where('telephone', $request->destinataire_telephone)
        )->firstOrFail();

        $this->authorize('transfer', $emetteur);

        $this->transfertService->transfert($emetteur, $recepteur, $request->montant);

        return response()->json(['message' => 'Transfert effectué']);
    }
}
