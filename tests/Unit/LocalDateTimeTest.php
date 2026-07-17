<?php

namespace Tests\Unit;

use App\Support\LocalDateTime;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class LocalDateTimeTest extends TestCase
{
    public function test_it_converts_utc_timestamps_to_colombo_time(): void
    {
        config()->set('app.display_timezone', 'Asia/Colombo');

        $timestamp = Carbon::create(2026, 7, 17, 18, 33, 0, 'UTC');

        $this->assertSame('2026-07-18 00:03', LocalDateTime::format($timestamp));
    }

    public function test_it_uses_the_fallback_for_missing_timestamps(): void
    {
        $this->assertSame('Not available', LocalDateTime::format(null, fallback: 'Not available'));
    }
}
