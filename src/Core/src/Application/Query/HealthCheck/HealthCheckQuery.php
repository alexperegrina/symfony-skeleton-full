<?php
declare(strict_types=1);

namespace Core\Application\Query\HealthCheck;

use Core\Domain\Messenger\Message\Query;

class HealthCheckQuery implements Query
{
    private function __construct()
    {}

    public static function make(): self
    {
        return new self();
    }
}