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
        Schema::create('jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('jabatan')->unique()->fillable();
            $table->unsignedBigInteger('id_perangkat_daerah');
            $table->foreign('id_perangkat_daerah')->references('id')->on('perangkat_daerahs')->onDelete('cascade');
            $table->text('prioritas')->nullable()->fillable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatans');
    }
};
