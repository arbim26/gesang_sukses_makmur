<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ERD: Barang (Part_No PK, Name_Part, Jenis, Unit_Price, Unit_Means)
        Schema::create('barangs', function (Blueprint $table) {
            $table->string('Kode_Barang', 20)->primary();  // Part_No di ERD
            $table->string('Nama_Barang', 100);            // Name_Part di ERD
            $table->string('Jenis', 50)->nullable();
            $table->decimal('Unit_Price', 15, 2);
            $table->string('Unit_Means', 20)->nullable();  // satuan: pcs, kg, dll
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
