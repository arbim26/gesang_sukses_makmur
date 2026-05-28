<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->string('Id_Pegawai', 20)->primary();
            $table->string('Nama_Pegawai', 100);
            $table->enum('Jabatan', ['CEO', 'Sekretaris', 'Supir', 'Staff']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
