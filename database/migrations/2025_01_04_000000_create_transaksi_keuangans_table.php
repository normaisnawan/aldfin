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
    Schema::create('transaksi_keuangans', function (Blueprint $table) {
      $table->id();
      $table->date('tanggal');
      $table->enum('jenis', ['pemasukan', 'pengeluaran']);
      $table->foreignId('akun_id')->constrained('akuns')->onDelete('restrict');
      $table->foreignId('outlet_id')->constrained('outlets')->onDelete('restrict');
      $table->decimal('jumlah', 15, 2);
      $table->text('keterangan')->nullable();
      $table->string('sumber')->nullable(); // penjualan, pembelian, pemasukan, pengeluaran
      $table->unsignedBigInteger('referensi_id')->nullable();
      $table->softDeletes();
      $table->timestamps();

      $table->index(['tanggal', 'jenis']);
      $table->index('sumber');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('transaksi_keuangans');
  }
};
