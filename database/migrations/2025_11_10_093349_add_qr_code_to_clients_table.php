<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'qr_code')) {
                $table->string('qr_code')->nullable();
            }
            if (!Schema::hasColumn('clients', 'is_active')) {
                $table->boolean('is_active')->default(false);
            }
            if (!Schema::hasColumn('clients', 'password')) {
                $table->string('password')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
};
