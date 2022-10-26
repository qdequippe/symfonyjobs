<?php

namespace App\Clock;

use DateTimeImmutable;
use StellaMaris\Clock\ClockInterface;

final class SystemClock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
