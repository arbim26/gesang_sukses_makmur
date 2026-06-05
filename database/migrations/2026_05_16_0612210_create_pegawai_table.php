<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->string('Id_Pegawai', 20)->primary();
            $table->string('password', 255)->nullable(); // Kolom untuk keamanan login
            $table->rememberToken(); // Kolom remember_token bawaan Laravel
            $table->string('Nama_Pegawai', 100);
            $table->enum('Jabatan', ['Staf IT', 'Direksi', 'Manajer', 'Sekretaris', 'Bendahara', 'Staf', 'Pengemudi']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};