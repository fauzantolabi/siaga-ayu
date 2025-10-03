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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');
            $table->date('tanggal')->fillable();
            $table->time('waktu')->nullable();
            $table->string('agenda')->nullable()->fillable();
            $table->unsignedBigInteger('id_jabatan')->nullable();
            $table->foreign('id_jabatan')->references('id')->on('jabatans')->onDelete('set null');
            $table->string('tempat')->nullable()->fillable();
            $table->unsignedBigInteger('id_pakaian')->nullable();
            $table->foreign('id_pakaian')->references('id')->on('pakaians')->onDelete('set null');
            $table->unsignedBigInteger('id_surat')->nullable();
            $table->foreign('id_surat')->references('id')->on('surats')->onDelete('set null');
            $table->text('resume')->nullable();
            $table->string('foto')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
