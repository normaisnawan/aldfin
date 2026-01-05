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
    Schema::create('pengeluarans', function (Blueprint $table) {
      $table->id();
      $table->date('tanggal');
      $table->foreignId('akun_id')->constrained('akuns')->onDelete('restrict');
      $table->foreignId('outlet_id')->constrained('outlets')->onDelete('restrict');
      $table->decimal('jumlah', 15, 2);
      $table->text('keterangan')->nullable();
      $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
      $table->timestamp('paid_at')->nullable();
      $table->foreignId('transaksi_keuangan_id')->nullable()->constrained('transaksi_keuangans')->onDelete('set null');
      $table->softDeletes();
      $table->timestamps();

      $table->index(['tanggal', 'status']);
      $table->index('status');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pengeluarans');
  }
};
