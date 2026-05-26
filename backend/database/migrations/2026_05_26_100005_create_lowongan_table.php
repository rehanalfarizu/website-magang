<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mitra_id')->nullable()->constrained('mitra')->nullOnDelete();
            $table->string('posisi', 255)->notNull();
            $table->integer('kuota')->default(1);
            $table->text('deskripsi_task')->nullable();
            $table->text('requirements')->nullable();
            $table->string('lokasi', 255)->nullable();
            $table->date('batas_daftar')->nullable();
            $table->string('status', 30)->default('draft')
                  ->comment('draft, menunggu_kurasi, published, ditolak, revisi');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongan');
    }
};
