<?php
declare(strict_types=1);

namespace Core\Interfaces\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebController extends ApiRestController
{
    #[Route('/test', name: 'core_web_get_test', methods: ['GET'])]
    public function test(): Response
    {
        $number = random_int(0, 100);

        return $this->render('@Core/test.html.twig', [
            'number' => $number,
        ]);
    }

    #[Route('/home', name: 'core_web_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('@Core/base.html.twig', []);
    }

    #[Route('/private', name: 'core_web_private', methods: ['GET'])]
    public function private(): Response
    {
        return $this->render('@Core/base.html.twig', []);
    }
}