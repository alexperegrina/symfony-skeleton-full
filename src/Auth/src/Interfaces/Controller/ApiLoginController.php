<?php
declare(strict_types=1);

namespace Auth\Interfaces\Controller;

use Auth\Domain\Entity\User;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
    #[Route('/json', name: 'auth_api_login_json', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = 'aaa'; // somehow create an API token for $user

        return $this->json([
           'user'  => $user->getUserIdentifier(),
           'token' => $token,
       ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/jwt', name: 'auth_api_login_jwt', methods: ['POST'])]
    public function jwt(): void
    {
        // controller can be blank: it will never be called!
        throw new Exception('Don\'t forget to activate logout in security.yaml');
    }
}