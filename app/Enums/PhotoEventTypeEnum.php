<?php

namespace App\Enums;

class PhotoEventTypeEnum
{
    const KWITANSI = 'Kwitansi';
    const DETAIL_BIAYA = 'Detail Biaya';
    const FOTO_EVALUASI = 'Foto Evaluasi';
    const JENIS_EVENT = 'Jenis Event';
    CONST EVALUASI = 'Evaluasi';

    /**
     * Get the display name of the enum value.
     */
    public static function getAll(): array
    {
        return [
            self::KWITANSI => 'Kwitansi',
            self::DETAIL_BIAYA => 'Detail Biaya',
            self::FOTO_EVALUASI => 'Foto Evaluasi',
            self::JENIS_EVENT => 'Jenis Event',
            self::EVALUASI => 'Evaluasi',
        ];
    }
}
