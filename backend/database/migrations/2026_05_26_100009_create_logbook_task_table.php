<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbook_task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('logbook_id')->constrained('logbook')->cascadeOnDelete();
            $table->string('deskripsi_task', 500)->notNull();
            $table->string('status', 20)->default('pending')
                  ->comment('pending, dikerjakan, selesai');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbook_task');
    }
};
