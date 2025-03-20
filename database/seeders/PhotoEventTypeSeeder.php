<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PhotoEventType;

class PhotoEventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $photoEventTypes = [
            ['photo_event_type_name' => 'Kwitansi'],
            ['photo_event_type_name' => 'Detail Biaya'],
            ['photo_event_type_name' => 'Foto Evaluasi'],
            ['photo_event_type_name' => 'Jenis Event'],
            ['photo_event_type_name' => 'Evaluasi'],
        ];

        foreach ($photoEventTypes as $type) {
            PhotoEventType::updateOrCreate($type);
        }
    }
}
