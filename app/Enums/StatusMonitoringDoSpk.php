<?php

namespace App\Enums;

enum StatusMonitoringDoSpk: string
{
    const ON_THE_TRACK = 'ON THE TRACK';
    const PUSH_SPK = 'PUSH SPK';

    public static function values(): array
    {
        return [
            self::ON_THE_TRACK,
            self::PUSH_SPK,
        ];
    }
}
