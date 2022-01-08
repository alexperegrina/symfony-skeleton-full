<?php
declare(strict_types=1);

namespace Core\Application\Query\HealthCheck;

class HealthCheckService
{
    public function ok(): bool
    {
        return true;
    }
}