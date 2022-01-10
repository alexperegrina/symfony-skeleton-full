<?php
declare(strict_types=1);

namespace Core\Interfaces\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebController extends ApiRestController
{
    /**
     * @Route("/test", name="core_web_get_test", methods={"GET"})
     * @return Response
     */
    public function test(): Response
    {
        $number = random_int(0, 100);

        return $this->render('@Core/test.html.twig', [
            'number' => $number,
        ]);
    }
}