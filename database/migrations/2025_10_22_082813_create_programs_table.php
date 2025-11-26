<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_misi')->constrained('misis')->onDelete('cascade');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();

            // ✅ Cegah duplikasi program pada misi yang sama
            $table->unique(['id_misi', 'description']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
