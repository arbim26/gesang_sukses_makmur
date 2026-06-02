<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ERD: Invoice (No_Invoice PK, tanggal_terbit, discount, No_PO FK,
        //               Id_pegawai_CEO FK, Id_pegawai_sekre FK, Acc_No FK)
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('No_Invoice', 30)->primary();
            $table->string('No_PO', 30);
            $table->date('tanggal_terbit');
            $table->decimal('discount', 5, 2)->default(0);
            $table->string('Id_CEO', 20)->nullable();
            $table->string('Id_Sekretaris', 20)->nullable();
            $table->string('Acc_No', 30)->nullable();
            $table->timestamps();

            $table->foreign('No_PO')
                  ->references('No_PO')->on('purchase_orders')
                  ->restrictOnDelete();

            $table->foreign('Id_CEO')
                  ->references('Id_Pegawai')->on('pegawais')
                  ->nullOnDelete();

            $table->foreign('Id_Sekretaris')
                  ->references('Id_Pegawai')->on('pegawais')
                  ->nullOnDelete();

            $table->foreign('Acc_No')
                  ->references('Acc_No')->on('rekenings')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
