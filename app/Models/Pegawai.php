<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table      = 'pegawais';
    protected $primaryKey = 'Id_Pegawai';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $fillable   = ['Id_Pegawai', 'Nama_Pegawai', 'Jabatan'];

    public function invoicesSebagaiCEO()
    {
        return $this->hasMany(Invoice::class, 'Id_CEO', 'Id_Pegawai');
    }

    public function invoicesSebagaiSekretaris()
    {
        return $this->hasMany(Invoice::class, 'Id_Sekretaris', 'Id_Pegawai');
    }

    public function suratJalans()
    {
        return $this->hasMany(SuratJalan::class, 'Id_Supir', 'Id_Pegawai');
    }
}
