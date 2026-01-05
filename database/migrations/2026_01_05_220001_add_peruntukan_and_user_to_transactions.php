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
    Schema::table('pemasukans', function (Blueprint $table) {
      $table->foreignId('peruntukan_id')->nullable()->after('outlet_id')->constrained('peruntukans')->nullOnDelete();
      $table->foreignId('user_id')->nullable()->after('peruntukan_id')->constrained('users')->nullOnDelete();
    });

    Schema::table('pengeluarans', function (Blueprint $table) {
      $table->foreignId('peruntukan_id')->nullable()->after('outlet_id')->constrained('peruntukans')->nullOnDelete();
      $table->foreignId('user_id')->nullable()->after('peruntukan_id')->constrained('users')->nullOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('pemasukans', function (Blueprint $table) {
      $table->dropForeign(['peruntukan_id']);
      $table->dropForeign(['user_id']);
      $table->dropColumn(['peruntukan_id', 'user_id']);
    });

    Schema::table('pengeluarans', function (Blueprint $table) {
      $table->dropForeign(['peruntukan_id']);
      $table->dropForeign(['user_id']);
      $table->dropColumn(['peruntukan_id', 'user_id']);
    });
  }
};
