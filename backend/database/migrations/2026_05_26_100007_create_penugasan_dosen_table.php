<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penugasan_dosen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete();
            $table->foreignId('dosen_id')->constrained('dosen')->cascadeOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('admin_prodi')->nullOnDelete();
            $table->timestamp('assigned_at')->nullable();
            $table->boolean('aktif')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penugasan_dosen');
    }
};
