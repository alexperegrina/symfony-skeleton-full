<?php
declare(strict_types=1);

namespace Auth\Interfaces\Controller;

use Core\Interfaces\Controller\ApiRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class WebLoginController extends ApiRestController
{
    #[Route('/', name: 'auth_web_login', methods: ['GET'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@Auth/login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}