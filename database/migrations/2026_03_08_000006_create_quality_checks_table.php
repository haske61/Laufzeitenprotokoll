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
        Schema::create('quality_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')->constrained()->cascadeOnDelete();
            $table->dateTime('checked_at');
            $table->decimal('moisture_percentage', 5, 2)->nullable();
            $table->decimal('fat_content_percentage', 5, 2)->nullable();
            $table->decimal('particle_size_microns', 7, 2)->nullable();
            $table->decimal('temperature', 5, 1)->nullable();
            $table->decimal('viscosity', 7, 2)->nullable();
            $table->decimal('ph_value', 4, 2)->nullable();
            $table->boolean('passed')->default(true);
            $table->text('notes')->nullable();
            $table->foreignId('checked_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_checks');
    }
};
