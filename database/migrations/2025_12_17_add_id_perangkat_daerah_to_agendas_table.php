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
        Schema::table('agendas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_perangkat_daerah')->nullable()->after('id_user');
            $table->foreign('id_perangkat_daerah')->references('id')->on('perangkat_daerahs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropForeign(['id_perangkat_daerah']);
            $table->dropColumn('id_perangkat_daerah');
        });
    }
};
