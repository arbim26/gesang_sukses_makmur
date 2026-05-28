<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    protected $table      = 'surat_jalans';
    protected $primaryKey = 'No_SJ';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $fillable   = ['No_SJ', 'No_PO', 'Tanggal', 'Id_Supir', 'Keterangan'];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'No_PO', 'No_PO');
    }

    public function supir()
    {
        return $this->belongsTo(Pegawai::class, 'Id_Supir', 'Id_Pegawai');
    }

    public function customer()
    {
        return $this->hasOneThrough(
            Customer::class,
            PurchaseOrder::class,
            'No_PO',    // FK di purchase_orders
            'Id_Cust',  // FK di customers
            'No_PO',    // local key di surat_jalans
            'Id_Cust'   // local key di purchase_orders
        );
    }
}
