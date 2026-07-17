<?php

namespace App\Support;

use DateTimeInterface;
use Illuminate\Support\Carbon;

final class LocalDateTime
{
    public static function format(
        DateTimeInterface|string|null $value,
        string $format = 'Y-m-d H:i',
        string $fallback = '—'
    ): string {
        if ($value === null || $value === '') {
            return $fallback;
        }

        $dateTime = $value instanceof DateTimeInterface
            ? Carbon::instance($value)
            : Carbon::parse($value, config('app.timezone', 'UTC'));

        return $dateTime
            ->copy()
            ->setTimezone(config('app.display_timezone', 'Asia/Colombo'))
            ->format($format);
    }
}
