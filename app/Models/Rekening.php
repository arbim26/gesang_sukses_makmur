<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $table      = 'rekenings';
    protected $primaryKey = 'Acc_No';
    public    $incrementing = false;
    protected $keyType    = 'string';
    protected $fillable   = ['Acc_No', 'Bank', 'Nama'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'Acc_No', 'Acc_No');
    }
}
