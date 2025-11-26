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
        Schema::table('surats', function (Blueprint $table) {
            // hapus ->after('id_user')
            $table->unsignedBigInteger('id_perangkat_daerah')->nullable();
            $table->foreign('id_perangkat_daerah')
                ->references('id')
                ->on('perangkat_daerahs')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            $table->dropForeign(['id_perangkat_daerah']);
            $table->dropColumn('id_perangkat_daerah');
        });
    }

};
