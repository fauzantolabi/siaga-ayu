<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('perangkat_daerahs', function (Blueprint $table) {
            $table->integer('prioritas')->default(999)->after('singkatan')->comment('Semakin kecil semakin tinggi prioritas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perangkat_daerahs', function (Blueprint $table) {
            $table->dropColumn('prioritas');
        });
    }
};
