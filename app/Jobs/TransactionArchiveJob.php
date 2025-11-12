<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TransactionArchiveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    // protected int $jour;
    // public function __construct( $jour = 1)
    // {
    //  $this->jour=$jour;
    // }

    /**
     * Execute the job.
     */
 public function handle(): void
{
    $dateLimite = now()->subDays(1); // transactions d'hier et avant
//     dispatch() → met le job dans la queue → nécessite queue:work.

// dispatchSync() → exécute directement → pas besoin de worker
    $transactions = Transaction::where('archive', false)
        ->whereDate('date_transaction', '<', $dateLimite)
        ->get();

    Log::info('Transactions à archiver : ' . $transactions->count());

    foreach ($transactions as $transaction) {
        $transaction->update(['archive' => true]);
        Log::info("Transaction archivée : " . $transaction->id);
    }
}

}
