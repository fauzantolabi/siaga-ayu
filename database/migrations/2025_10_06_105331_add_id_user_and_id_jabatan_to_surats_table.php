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
            // Cek dan tambahkan hanya id_user jika belum ada
            if (!Schema::hasColumn('surats', 'id_user')) {
                $table->unsignedBigInteger('id_user')->nullable()->after('id');
                $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
            }
        });
    }


    public function down(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_jabatan']);
            $table->dropColumn(['id_user', 'id_jabatan']);
        });
    }
};
