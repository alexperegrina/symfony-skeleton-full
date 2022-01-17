<?php
declare(strict_types=1);

namespace Admin\Interfaces\Controller;

use Core\Interfaces\Controller\ApiRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPageSampleController extends ApiRestController
{
    #[Route('/404', name: 'admin_page_sample_404', methods: ['GET'])]
    public function page404(): Response
    {
        return $this->render('@Admin/sb-admin/page/sample/404.html.twig');
    }

    #[Route('/blank', name: 'admin_page_sample_blank', methods: ['GET'])]
    public function blankPage(): Response
    {
        return $this->render('@Admin/sb-admin/page/sample/blank.html.twig');
    }

    #[Route('/forgot-password', name: 'admin_page_sample_forgot_password', methods: ['GET'])]
    public function forgotPassword(): Response
    {
        return $this->render('@Admin/sb-admin/page/sample/forgot-password.html.twig');
    }

    #[Route('/login', name: 'admin_page_sample_login', methods: ['GET'])]
    public function login(): Response
    {
        return $this->render('@Admin/sb-admin/page/sample/login.html.twig');
    }

    #[Route('/register', name: 'admin_page_sample_register', methods: ['GET'])]
    public function register(): Response
    {
        return $this->render('@Admin/sb-admin/page/sample/register.html.twig');
    }
}