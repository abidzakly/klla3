<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('data')->insert([
            [
                'nama_supervisor' => 'ab',
                'target_do' => 2,
                'act_do' => 2,
                'gap' => 2,
                'ach' => 2.0,
                'target_spk' => 2,
                'act_spk' => 2,
                'gap_spk' => 2,
                'ach_spk' => 2.0,
                'status' => 'ba',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_supervisor' => '2v',
                'target_do' => 2,
                'act_do' => 2,
                'gap' => 32,
                'ach' => 4.0,
                'target_spk' => 5,
                'act_spk' => 1,
                'gap_spk' => 2,
                'ach_spk' => 2.0,
                'status' => 'sda',
                'created_at' => '2025-02-20 12:46:41',
                'updated_at' => '2025-02-20 12:46:41'
            ],
            [
                'nama_supervisor' => 'A',
                'target_do' => 2,
                'act_do' => 2,
                'gap' => 2,
                'ach' => 2.0,
                'target_spk' => 2,
                'act_spk' => 2,
                'gap_spk' => 2,
                'ach_spk' => 2.0,
                'status' => 'SVA',
                'created_at' => '2025-02-20 13:35:05',
                'updated_at' => '2025-02-20 13:35:05'
            ],
            [
                'nama_supervisor' => 'a',
                'target_do' => 2,
                'act_do' => 32,
                'gap' => 2,
                'ach' => 2.0,
                'target_spk' => 1,
                'act_spk' => 2,
                'gap_spk' => 32,
                'ach_spk' => 2.0,
                'status' => 'ads',
                'created_at' => '2025-02-20 13:50:56',
                'updated_at' => '2025-02-20 13:50:56'
            ],
            [
                'nama_supervisor' => 'a',
                'target_do' => 2,
                'act_do' => 32,
                'gap' => 21,
                'ach' => 232.0,
                'target_spk' => 2,
                'act_spk' => 2,
                'gap_spk' => 2,
                'ach_spk' => 2.0,
                'status' => 'asdadsa',
                'created_at' => '2025-02-20 14:09:59',
                'updated_at' => '2025-02-20 14:09:59'
            ]
        ]);
    }
}
