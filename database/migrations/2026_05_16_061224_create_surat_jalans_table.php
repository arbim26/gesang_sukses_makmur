<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ERD: Surat Jalan (No_SJ PK, No_PO FK, Tanggal, Id_Supir FK, Keterangan)
        // Relasi: Surat Jalan Memiliki Invoice (M ke M via No_PO)
        //         Surat Jalan — Mengirim — Pegawai (Supir)
        Schema::create('surat_jalans', function (Blueprint $table) {
            $table->string('No_SJ', 30)->primary();
            $table->string('No_PO', 30);
            $table->date('Tanggal');
            $table->string('Id_Supir', 20)->nullable();
            $table->text('Keterangan')->nullable();
            $table->timestamps();

            $table->foreign('No_PO')
                  ->references('No_PO')->on('purchase_orders')
                  ->restrictOnDelete();

            $table->foreign('Id_Supir')
                  ->references('Id_Pegawai')->on('pegawais')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_jalans');
    }
};
