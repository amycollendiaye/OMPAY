+<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comptes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('numero_compte');
            $table->enum("type", ["client", "distributeur"]);
            $table->enum("statut", ["actif", "suspendu"]);
            $table->date('date_creation')->default(now());
            $table->boolean("plafond")->default(true);
            $table->uuid('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->uuid('distributeur_id')->nullable();
            $table->index(["numero_compte", "type", "statut", "date_creation", "plafond", "client_id", "distributeur_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comptes');
    }
};
