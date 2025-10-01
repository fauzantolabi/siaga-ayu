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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('asal_surat')->fillable();
            $table->string('nomor_surat')->fillable();
            $table->string('perihal')->nullable()->fillable();
            $table->date('tanggal_surat')->nullable()->fillable();
            $table->date('tanggal_terima')->nullable()->fillable();
            $table->string('sifat_surat')->nullable()->fillable();
            $table->text('hal')->nullable()->fillable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
