<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ERD: Detail PO (No_Barang FK, No_PO FK, Qty, Amount, Metode)
        Schema::create('detail_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('No_PO', 30);
            $table->string('No_Barang', 20);
            $table->integer('Qty');
            $table->decimal('Unit_Price', 15, 2);
            $table->decimal('Amount', 15, 2);
            $table->string('Metode', 100)->nullable();
            $table->timestamps();

            $table->foreign('No_PO')
                  ->references('No_PO')->on('purchase_orders')
                  ->cascadeOnDelete();

            $table->foreign('No_Barang')
                  ->references('Kode_Barang')->on('barangs')
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_invoices');
    }
};