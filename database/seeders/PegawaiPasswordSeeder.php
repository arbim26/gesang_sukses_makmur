<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiPasswordSeeder extends Seeder
{
    public function run(): void
    {
        $total = DB::table('pegawais')->count();

        if ($total === 0) {
            $this->command->warn('Tabel pegawai masih kosong, tidak ada yang diupdate.');
            return;
        }
        
        // Pass 'Id_Pegawai' (case-sensitive) as the third argument for chunkById
        DB::table('pegawais')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                DB::table('pegawais')
                    ->where('Id_Pegawai', $row->Id_Pegawai)
                    ->update([
                        // FIXED: Changed from id_pegawai to Id_Pegawai
                        'password' => Hash::make($row->Id_Pegawai), 
                    ]);
            }
        }, 'Id_Pegawai'); // FIXED: Also ensured the chunk identifier matches your PK casing

        $this->command->info("Password berhasil diset untuk {$total} pegawai.");
    }
}