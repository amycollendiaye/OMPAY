<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // 🔹 Champ password (haché)
            if (!Schema::hasColumn('clients', 'password')) {
                $table->string('password')->nullable();
            }

            // 🔹 Champ pour forcer le changement du mot de passe
            if (!Schema::hasColumn('clients', 'must_change_password')) {
                $table->boolean('must_change_password')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['password', 'must_change_password']);
        });
    }
};
