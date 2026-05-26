<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbook', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete();
            $table->foreignId('mitra_id')->nullable()->constrained('mitra')->nullOnDelete();
            $table->foreignId('dosen_id')->nullable()->constrained('dosen')->nullOnDelete();
            $table->date('periode_bulan')->notNull();
            $table->text('deskripsi_aktivitas')->nullable();
            $table->string('status_review', 30)->default('draft')
                  ->comment('draft, dikirim, dibaca, diterima, perlu_revisi');
            $table->text('feedback_supervisor')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbook');
    }
};
