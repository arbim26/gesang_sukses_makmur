<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pegawai extends Authenticatable
{
    use Notifiable;

    protected $table = 'pegawais';
    protected $primaryKey = 'Id_Pegawai';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['Id_Pegawai', 'Nama_Pegawai', 'Jabatan', 'password'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getRole(): string
    {
        return strtolower(str_replace(' ', '_', trim($this->jabatan ?? 'staff')));
    }

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

    public function hasJabatan(string ...$jabatan): bool
    {
        return in_array(
            strtolower(trim($this->jabatan ?? '')),
            array_map(fn($j) => strtolower(trim($j)), $jabatan)
        );
    }
}
