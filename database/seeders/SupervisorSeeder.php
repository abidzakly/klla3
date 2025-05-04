<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Muh. Irfan M
         * Awaluddin
         * SPV Soppeng
         * Fandi Ahmad Aminuddin
         * Asri Ali
         * Rusman Kadir
         * Nurfajri Ashiddiq
         * Miswar
         * Moh. Helky
         * Haryanto Razak
         * Takdir Zulfikar
         * Adrianus Pasang
         * SPV LUWUK
         * MUH RISMAN THAMAR
         * A. ARMAN RASYID
         * HARTANTO
         * SPV KENDARI
         * ANDI BATARA B. PAWELLOI
         */

         $supervisors = [
            'Muh. Irfan M',
            'Awaluddin',
            'SPV Soppeng',
            'Fandi Ahmad Aminuddin',
            'Asri Ali',
            'Rusman Kadir',
            'Nurfajri Ashiddiq',
            'Miswar',
            'Moh. Helky',
            'Haryanto Razak',
            'Takdir Zulfikar',
            'Adrianus Pasang',
            'SPV LUWUK',
            'MUH RISMAN THAMAR',
            'A. ARMAN RASYID',
            'HARTANTO',
            'SPV KENDARI',
            'ANDI BATARA B. PAWELLOI',
        ];

        foreach ($supervisors as $supervisor) {
            \App\Models\Supervisor::firstOrCreate([
                'supervisor_name' => $supervisor,
            ]);
        }
    }
}
