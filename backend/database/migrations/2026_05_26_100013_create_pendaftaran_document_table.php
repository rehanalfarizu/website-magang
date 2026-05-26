<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_document', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete();
            $table->string('tipe', 30)->nullable()
                  ->comment('transkrip, cv, surat_lamaran, sertifikat, lainnya');
            $table->string('file_path', 500)->notNull();
            $table->timestamp('uploaded_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_document');
    }
};
