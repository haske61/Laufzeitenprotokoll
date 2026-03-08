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
        Schema::create('machine_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('type', ['breakdown', 'maintenance', 'cleaning', 'other']);
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->text('description');
            $table->text('cause')->nullable();
            $table->text('resolution')->nullable();
            $table->text('parts_replaced')->nullable();
            $table->foreignId('reported_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['reported', 'in_progress', 'resolved'])->default('reported');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_breakdowns');
    }
};
