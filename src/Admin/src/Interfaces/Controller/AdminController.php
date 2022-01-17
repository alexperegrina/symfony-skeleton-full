<?php
declare(strict_types=1);

namespace Admin\Interfaces\Controller;

use Auth\Domain\Entity\User;
use Core\Interfaces\Controller\ApiRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AdminController extends ApiRestController
{
    #[Route('/', name: 'admin_home', methods: ['GET'])]
    public function home(#[CurrentUser] ?User $user): Response
    {
        return $this->render('@Admin/sb-admin/base.html.twig');
//        return $this->render('@Admin/base.html.twig');
    }
}