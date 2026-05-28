<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RekeningSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rekenings')->insert([
            [
                'Acc_No'     => 'BCA-001-123456',
                'Bank'       => 'BCA',
                'Nama'       => 'PT Gesang Sukses Makmur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Acc_No'     => 'BRI-002-654321',
                'Bank'       => 'BRI',
                'Nama'       => 'PT Gesang Sukses Makmur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Acc_No'     => 'MANDIRI-003-789012',
                'Bank'       => 'Bank Mandiri',
                'Nama'       => 'PT Gesang Sukses Makmur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
