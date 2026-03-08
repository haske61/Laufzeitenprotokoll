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
        Schema::create('bean_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->string('origin_country');
            $table->string('bean_type')->nullable();
            $table->string('batch_number')->unique();
            $table->date('delivery_date');
            $table->decimal('quantity_kg', 10, 2);
            $table->decimal('moisture_percentage', 5, 2)->nullable();
            $table->decimal('fat_content_percentage', 5, 2)->nullable();
            $table->string('quality_grade')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bean_deliveries');
    }
};
