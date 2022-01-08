<?php
declare(strict_types=1);

namespace Core\Application\Query\HealthCheck;

use Core\Domain\Messenger\Handler\QueryHandler;

class HealthCheckHandler implements QueryHandler
{
    public function __construct(private HealthCheckService $healthCheckService)
    {}

    public function __invoke(HealthCheckQuery $query): bool
    {
        return $this->healthCheckService->ok();
    }
}