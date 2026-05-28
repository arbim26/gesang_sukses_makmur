<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table      = 'customers';
    protected $primaryKey = 'Id_Cust';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $fillable   = ['Id_Cust', 'Nama', 'PIC'];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'Id_Cust', 'Id_Cust');
    }

    public function suratJalans()
    {
        return $this->hasManyThrough(
            SuratJalan::class,
            PurchaseOrder::class,
            'Id_Cust',  // FK di purchase_orders
            'No_PO',    // FK di surat_jalans
            'Id_Cust',  // local key di customers
            'No_PO'     // local key di purchase_orders
        );
    }
}
