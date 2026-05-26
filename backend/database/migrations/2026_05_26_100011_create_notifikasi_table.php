<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('tipe', 50)->nullable()
                  ->comment('PENDAFTARAN_STATUS, LOGBOOK_DIBACA, LOGBOOK_DITERIMA, dll');
            $table->string('judul', 255)->notNull();
            $table->text('pesan')->nullable();
            $table->unsignedBigInteger('data_id')->nullable();
            $table->string('data_type', 50)->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
