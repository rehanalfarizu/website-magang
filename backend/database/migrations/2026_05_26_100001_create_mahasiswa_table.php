<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('nim', 20)->unique()->notNull();
            $table->string('nama', 255)->notNull();
            $table->decimal('ipk', 3, 2)->nullable()->comment('min 3.0 untuk bisa daftar magang');
            $table->integer('semester')->nullable()->comment('min 5 untuk bisa daftar magang');
            $table->string('no_telepon', 20)->nullable();
            $table->string('status_magang', 30)->default('belum_magang');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
