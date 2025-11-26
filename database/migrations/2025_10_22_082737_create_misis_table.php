<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('misis', function (Blueprint $table) {
            $table->id();
            $table->string('misi');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes(); // untuk deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('misis');
    }
};
