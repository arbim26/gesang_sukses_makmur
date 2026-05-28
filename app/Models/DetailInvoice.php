<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailInvoice extends Model
{
    protected $table    = 'detail_invoices';
    protected $fillable = ['No_PO', 'No_Barang', 'Qty', 'Unit_Price', 'Amount', 'Metode'];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'No_PO', 'No_PO');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'No_Barang', 'Kode_Barang');
    }
}
