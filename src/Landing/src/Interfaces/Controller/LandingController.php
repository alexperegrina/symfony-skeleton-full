<?php
declare(strict_types=1);

namespace Landing\Interfaces\Controller;

use Auth\Domain\Entity\User;
use Core\Interfaces\Controller\ApiRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LandingController extends ApiRestController
{
    #[Route('/', name: 'landing_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('@Landing/grayscale/base.html.twig');
//        return $this->render('@Landing/base.html.twig');
    }

//    #[Route('/profile', name: 'landing_profile', methods: ['GET'])]
//    public function profile(#[CurrentUser] ?User $user): Response
//    {
//        return $this->render('@Landing/base.html.twig');
//    }
}