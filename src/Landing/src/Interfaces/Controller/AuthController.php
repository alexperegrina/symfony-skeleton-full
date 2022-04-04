<?php
declare(strict_types=1);

namespace Landing\Interfaces\Controller;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Auth\Application\Command\AddRole\AddRoleCommand;
use Auth\Application\Command\CreateUser\CreateUserCommand;
use Auth\Application\Command\SendEmailConfirmation\SendEmailConfirmationCommand;
use Auth\Application\Command\SetName\SetNameCommand;
use Auth\Application\Form\SignUpForm;
use Auth\Domain\ValueObject\Role;
use Core\Interfaces\Controller\ApiRestController;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends ApiRestController
{
    #[Route('/login', name: 'landing_auth_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@Landing/grayscale/auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/logout', name: 'landing_auth_logout', methods: ['GET'])]
    public function logout(): void
    {
        // controller can be blank: it will never be called!
        throw new Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route('/sign-up', name: 'landing_auth_sign-up', methods: ['GET', 'POST'])]
    public function signUp(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(SignUpForm::class, null, [
            'action' => $this->generateUrl('landing_auth_sign-up')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $id = Uuid::uuid4();
            $name = $form->get('name')->getData();
            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();

            $command = CreateUserCommand::make($id->value(), $email, $password);
            $this->commandBus->dispatch($command);

            $command = AddRoleCommand::make($id->value(), Role::LANDING);
            $this->commandBus->dispatch($command);

            $lastName = explode(' ', $name['last']);
            $command = SetNameCommand::make($id->value(), $name['first'], $name['last']);
            if (count($lastName) > 1) {
                $command = SetNameCommand::make($id->value(), $name['first'], $lastName[0], $lastName[1]);
            }
            $this->commandBus->dispatch($command);

            $command = SendEmailConfirmationCommand::make($id->value());
            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('landing_auth_login');
        }

        return $this->renderForm('@Landing/grayscale/auth/sign-up.html.twig', [
            'signUpForm' => $form,
        ]);
    }

    #[Route('/sign-up/google', name: 'landing_auth_sign-up_google', methods: ['GET', 'POST'])]
    public function signUpGoogle(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('@Landing/grayscale/auth/login.html.twig', [
            'last_username' => null,
            'error' => null,
        ]);
    }

    #[Route('/sign-up/facebook', name: 'landing_auth_sign-up_facebook', methods: ['GET', 'POST'])]
    public function signUpFacebook(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('@Landing/grayscale/auth/login.html.twig', [
            'last_username' => null,
            'error' => null,
        ]);
    }
}