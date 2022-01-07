<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController
{
    /**
     * @Route("/ping", name="app_health_check_get_ping", methods={"GET"})
     * @return JsonResponse
     */
    public function ping(): JsonResponse
    {
        return new JsonResponse('Ping');
    }
}