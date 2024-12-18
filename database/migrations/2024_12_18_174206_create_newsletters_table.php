<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('process_status', ['pending', 'start', 'started', 'completed'])->default('pending');
            $table->timestamp('send_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};
