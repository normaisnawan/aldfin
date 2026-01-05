<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add column as nullable first
        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->string('nomor_transaksi', 20)->nullable()->after('id');
        });

        // Step 2: Generate transaction numbers for existing records
        $pengeluarans = DB::table('pengeluarans')
            ->whereNull('nomor_transaksi')
            ->orWhere('nomor_transaksi', '')
            ->orderBy('created_at', 'asc')
            ->get();

        $yearCounts = [];

        foreach ($pengeluarans as $pengeluaran) {
            $year = date('y', strtotime($pengeluaran->created_at));

            if (!isset($yearCounts[$year])) {
                // Check existing count for this year
                $existingCount = DB::table('pengeluarans')
                    ->where('nomor_transaksi', 'like', "TROUT-{$year}-%")
                    ->count();
                $yearCounts[$year] = $existingCount;
            }

            $yearCounts[$year]++;
            $nomorTransaksi = 'TROUT-' . $year . '-' . str_pad($yearCounts[$year], 5, '0', STR_PAD_LEFT);

            DB::table('pengeluarans')
                ->where('id', $pengeluaran->id)
                ->update(['nomor_transaksi' => $nomorTransaksi]);
        }

        // Step 3: Add unique constraint
        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->unique('nomor_transaksi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->dropUnique(['nomor_transaksi']);
            $table->dropColumn('nomor_transaksi');
        });
    }
};
