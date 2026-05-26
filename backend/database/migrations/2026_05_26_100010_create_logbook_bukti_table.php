<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbook_bukti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('logbook_id')->constrained('logbook')->cascadeOnDelete();
            $table->string('file_path', 500)->notNull();
            $table->string('tipe', 20)->nullable()->comment('foto, dokumen, pdf, jpg, png');
            $table->timestamp('uploaded_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbook_bukti');
    }
};
