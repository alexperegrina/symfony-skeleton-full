<?php
declare(strict_types=1);

namespace Landing\Interfaces\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController
{
    #[Route('/ping', name: 'landing_health_check_get_ping', methods: ['GET'])]
    public function ping(): JsonResponse
    {
        return new JsonResponse('Ping');
    }
}