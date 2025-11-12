<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class ArchiveOldTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
            Log::info('ArchiveTransactionsJob running...');

        $today = now();  //  la date et  heure   actuelle  defalut

        

        $transactions = Transaction::whereDate('created_at',"<", $today)
            ->where('archive', false)
            ->orderBy('created_at', 'asc')
            ->limit(5)
            ->get();
        if ($transactions->isEmpty()) {
            log::info("AUCUME TRANSACTION A ARCHIVE AUJOURDHUI");
        }
        foreach ($transactions as $transaction) {

            DB::connection('neon')->table('transactions_archives')->insert([
                'id' => $transaction->id,
                'type' => $transaction->type,
                'montant' => $transaction->montant,
                'date_transaction' => $transaction->date_transaction,
                'numero_reference' => $transaction->numero_reference,
                'code_marchand' => $transaction->code_marchand,
                'compte_emetteur_id' => $transaction->compte_emetteur_id,
                'compte_beneficiaire_id' => $transaction->compte_beneficaire_id,
                'statut' => $transaction->statut,
                'created_at' => $transaction->created_at,
                'updated_at' => $transaction->updated_at,
            ]);
            $transaction->update(['archive' => true]);
            Log::info('Transaction archivée', ['id' => $transaction->id]);
        }
    }
}
