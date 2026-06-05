<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table      = 'purchase_orders';
    protected $primaryKey = 'No_PO';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $fillable   = [
        'No_PO', 'Id_Cust', 'PO_Date', 'Delivery_date',
        'Sub_Total', 'PPN', 'Grand_Total', 'Note','attachment',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'Id_Cust', 'Id_Cust');
    }

    public function details()
    {
        return $this->hasMany(DetailInvoice::class, 'No_PO', 'No_PO');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'No_PO', 'No_PO');
    }

    public function suratJalan()
    {
        return $this->hasOne(SuratJalan::class, 'No_PO', 'No_PO');
    }
}
