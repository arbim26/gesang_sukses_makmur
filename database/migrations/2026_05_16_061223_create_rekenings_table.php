<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ERD: Rekening (Acc_No PK, Bank, Nama)
        Schema::create('rekenings', function (Blueprint $table) {
            $table->string('Acc_No', 30)->primary();
            $table->string('Bank', 100);
            $table->string('Nama', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekenings');
    }
};
