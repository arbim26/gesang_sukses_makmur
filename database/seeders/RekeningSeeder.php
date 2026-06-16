<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RekeningSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rekenings')->insert([
            [
                'Acc_No'     => '4205563240',
                'Bank'       => 'PERMATA',
                'Nama'       => 'Syamsul Bahri Fitriyanto',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Acc_No'     => '1234567890',
                'Bank'       => 'BCA',
                'Nama'       => 'PT. Gesang Sukses Makmur',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
