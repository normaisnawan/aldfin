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
    Schema::create('formulas', function (Blueprint $table) {
      $table->id();
      $table->string('nama');
      $table->text('deskripsi')->nullable();
      $table->decimal('harga_jual', 15, 2)->nullable();
      $table->timestamps();
      $table->softDeletes();
    });

    Schema::create('formula_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('formula_id')->constrained('formulas')->onDelete('cascade');
      $table->foreignId('bahan_id')->constrained('bahans');
      $table->decimal('qty', 10, 2);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('formula_items');
    Schema::dropIfExists('formulas');
  }
};
