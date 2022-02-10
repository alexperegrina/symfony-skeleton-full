<?php
declare(strict_types=1);

namespace Admin\Interfaces\Controller;

use Admin\Interfaces\Parameters\AdminParameters;
use Auth\Application\Query\FindAllUsers\FindAllUsersQuery;
use Auth\Domain\Entity\User;
use Core\Interfaces\Controller\ApiRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AdminController extends ApiRestController
{
    #[Route('/', name: 'admin_home', methods: ['GET'])]
    public function home(#[CurrentUser] User $user): Response
    {
        return $this->render('@Admin/sb-admin/base.html.twig', AdminParameters::home($user));
    }

    #[Route('/dashboard', name: 'admin_dashboard', methods: ['GET'])]
    public function dashboard(#[CurrentUser] User $user): Response
    {
        return $this->render('@Admin/sb-admin/page/dashboard.html.twig', AdminParameters::dashboard($user));
    }

    #[Route('/users', name: 'admin_users', methods: ['GET'])]
    public function users(#[CurrentUser] User $user): Response
    {
        $query = FindAllUsersQuery::make();
        $users = $this->queryBus->dispatch($query);

        return $this->render('@Admin/sb-admin/page/user/list.html.twig', AdminParameters::users($user, $users));
    }
}