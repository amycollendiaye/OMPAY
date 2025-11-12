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
         // cest une methode native de php  qui me permet de  soustraire la date - jour
        // $dateLimite = now()->subDays($this->jour);
        $dateLimite = now();

        $transactions = Transaction::where('archive', false)
            // ->whereDate('created_at', '<', $dateLimite)
            // ->orderBy('created_at', 'asc')
            // ->limit(2)
            ->get();
            var_dump($transactions);
            Log::info($transactions);
        foreach ($transactions as $transaction) {
            $transaction->update(['archive' => true]);
        }

        Log::info("{$transactions->count()} transactions archivées (avant {$dateLimite->toDateString()})");
    }
    
}
