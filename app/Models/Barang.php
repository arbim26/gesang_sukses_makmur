<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table      = 'barangs';
    protected $primaryKey = 'Kode_Barang';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $fillable   = ['Kode_Barang', 'Nama_Barang', 'Jenis', 'Unit_Price', 'Unit_Means'];

    public function detailInvoices()
    {
        return $this->hasMany(DetailInvoice::class, 'No_Barang', 'Kode_Barang');
    }
}
