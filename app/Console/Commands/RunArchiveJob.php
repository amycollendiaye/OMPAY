<?php

namespace App\Console\Commands;

use App\Jobs\ArchiveOldTransactionJob;
use App\Jobs\TransactionArchiveJob;
use Illuminate\Console\Command;

class RunArchiveJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:archive-transactions-amycolle ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exécute manuellement le job d’archivage des transactions.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $days = $this->option('days');

         $this->info(" Lancement du job d’archivage des transactions les plus anciennes de de l'applicaction OMPAY   jour(s))...");

        // Dispatch du job dans la file d’attente
        dispatch(new TransactionArchiveJob());

        $this->info(' Job d’archivage lancé avec succès !');
    }
}
