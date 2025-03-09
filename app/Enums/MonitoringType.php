<?php

namespace App\Enums;

enum MonitoringType: string
{
    const DO = 'DO';
    const SPK = 'SPK';

    public static function values(): array
    {
        return [
            self::DO,
            self::SPK,
        ];
    }
}
