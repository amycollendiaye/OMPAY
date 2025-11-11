<?php

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
        Schema::table('distributeurs', function (Blueprint $table) {
            $table->string('code_marchand')->unique()->after('code_secret');
            $table->index('code_marchand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distributeurs', function (Blueprint $table) {
            $table->dropIndex(['code_marchand']);
            $table->dropColumn('code_marchand');
        });
    }
};
