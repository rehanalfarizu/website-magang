<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookmark', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->cascadeOnDelete();
            $table->foreignId('lowongan_id')->constrained('lowongan')->cascadeOnDelete();
            $table->timestamp('created_at')->nullable();

            $table->unique(['mahasiswa_id', 'lowongan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookmark');
    }
};
