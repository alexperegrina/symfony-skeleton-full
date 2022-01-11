<?php
declare(strict_types=1);

namespace Auth\Interfaces\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController
{
    #[Route('/ping', name: 'auth_health_check_get_ping', methods: ['GET'])]
    public function ping(): JsonResponse
    {
        return new JsonResponse('Ping');
    }
}