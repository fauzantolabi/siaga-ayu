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
            // Tambahkan kolom id_misi dan id_program
            $table->foreignId('id_misi')
                ->nullable()
                ->constrained('misis')
                ->onDelete('set null');

            $table->foreignId('id_program')
                ->nullable()
                ->constrained('programs')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropForeign(['id_misi']);
            $table->dropForeign(['id_program']);
            $table->dropColumn(['id_misi', 'id_program']);
        });
    }
};
