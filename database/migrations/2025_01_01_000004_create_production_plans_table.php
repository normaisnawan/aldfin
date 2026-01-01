<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('production_plans', function (Blueprint $table) {
      $table->id();
      $table->foreignId('customer_id')->constrained('customers');
      $table->foreignId('formula_id')->constrained('formulas');
      $table->date('tanggal');
      $table->integer('porsi');
      $table->string('status')->default('Planned'); // Planned, In Progress, Completed, Cancelled
      $table->timestamps();
      $table->softDeletes();
    });

    Schema::create('production_plan_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('production_plan_id')->constrained('production_plans')->onDelete('cascade');
      $table->foreignId('bahan_id')->constrained('bahans');
      $table->decimal('qty_per_porsi', 10, 4); // Store original qty per portion for reference
      $table->decimal('total_qty', 15, 4); // Calculated total
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('production_plan_items');
    Schema::dropIfExists('production_plans');
  }
};
