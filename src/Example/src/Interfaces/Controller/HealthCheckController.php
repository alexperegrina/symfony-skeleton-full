<?php
declare(strict_types=1);

namespace Example\Interfaces\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController
{
    #[Route('/ping', name: 'example_health_check_get_ping', methods: ['GET'])]
    public function ping(): JsonResponse
    {
        return new JsonResponse('Ping');
    }
}