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
        Schema::create('agenda_jabatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_agenda');
            $table->foreign('id_agenda')->references('id')->on('agendas')->onDelete('cascade');
            $table->unsignedBigInteger('id_jabatan');
            $table->foreign('id_jabatan')->references('id')->on('jabatans')->onDelete('cascade');
            $table->timestamps();

            // Prevent duplicate entries
            $table->unique(['id_agenda', 'id_jabatan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_jabatan');
    }
};
