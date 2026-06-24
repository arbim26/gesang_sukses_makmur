<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table      = 'invoices';
    protected $primaryKey = 'No_Invoice';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $fillable   = [
        'No_Invoice', 'No_PO', 'tanggal_terbit',
        'discount', 'Id_CEO', 'Id_Sekretaris', 'Acc_No',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'No_PO', 'No_PO');
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'Acc_No', 'Acc_No');
    }

    public function ceo()
    {
        return $this->belongsTo(Pegawai::class, 'Id_CEO', 'Id_Pegawai');
    }

    public function sekretaris()
    {
        return $this->belongsTo(Pegawai::class, 'Id_Sekretaris', 'Id_Pegawai');
    }

    public function No_SJ() {
        return $this->hasMany(SuratJalan::class, 'No_PO', 'No_PO'); 
    }

    // Shortcut ke customer melalui PO
    public function customer()
    {
        return $this->hasOneThrough(
            Customer::class,
            PurchaseOrder::class,
            'No_PO',   // FK di purchase_orders
            'Id_Cust', // FK di customers
            'No_PO',   // local key di invoices
            'Id_Cust'  // local key di purchase_orders
        );
    }
}
