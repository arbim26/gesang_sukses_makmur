<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ERD: Purchase Order (No_PO PK, PO_Date, Delivery_date, Sub_Total,
        //                      Grand_Total, PPN_11%, Note, Id_Cust FK)
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->string('No_PO', 30)->primary();
            $table->string('Id_Cust', 20);
            $table->date('PO_Date');
            $table->date('Delivery_date')->nullable();
            $table->decimal('Sub_Total', 15, 2)->default(0);
            $table->decimal('PPN', 5, 2)->default(11);     // PPN 11%
            $table->decimal('Grand_Total', 15, 2)->default(0);
            $table->text('Note')->nullable();
            $table->timestamps();

            $table->foreign('Id_Cust')
                  ->references('Id_Cust')->on('customers')
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};