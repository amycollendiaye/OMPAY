<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['paiement', 'transfert']);
            $table->decimal('montant', 15, 2);
            $table->date('date_transaction')->default(now());
            $table->string('numero_reference')->unique();
            $table->string('code_marchand')->nullable();

            $table->uuid('compte_emetteur_id');
            $table->foreign('compte_emetteur_id')
                ->references('id')
                ->on('comptes')
                ->onDelete('cascade');

            $table->uuid('compte_beneficiaire_id');
            $table->foreign('compte_beneficiaire_id')
                ->references('id')
                ->on('comptes')
                ->onDelete('cascade');

            $table->enum('statut', ['valide', 'en_attente', 'annule'])->default('en_attente');

            $table->index([
                'type',
                'montant',
                'date_transaction',
                'numero_reference',
                'code_marchand',
                'compte_emetteur_id',
                'compte_beneficiaire_id',
                'statut'
            ]);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
