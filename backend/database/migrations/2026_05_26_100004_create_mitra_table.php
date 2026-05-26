<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mitra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('nama_perusahaan', 255)->notNull();
            $table->text('alamat')->nullable();
            $table->string('pic_nama', 255)->nullable();
            $table->string('pic_email', 255)->nullable();
            $table->string('pic_telepon', 20)->nullable();
            $table->string('status', 20)->default('pending')->comment('pending, approved, rejected');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mitra');
    }
};
