<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            if (!Schema::hasColumn('surats', 'id_jabatan')) {
                $table->unsignedBigInteger('id_jabatan')->nullable()->after('id');
                $table->foreign('id_jabatan')->references('id')->on('jabatans')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            if (Schema::hasColumn('surats', 'id_jabatan')) {
                $table->dropForeign(['id_jabatan']);
                $table->dropColumn('id_jabatan');
            }
        });
    }
};
