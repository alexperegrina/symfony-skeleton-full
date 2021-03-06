<?php
declare(strict_types=1);

namespace Auth\Interfaces\Controller;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Auth\Application\Command\CreateUser\CreateUserCommand;
use Auth\Application\Command\SendEmailConfirmation\SendEmailConfirmationCommand;
use Auth\Application\Command\ValidateEmailConfirmation\ValidateEmailConfirmationCommand;
use Auth\Application\Form\RegistrationFormType;
use Core\Domain\Exception\EntityNotFoundByIdException;
use Core\Interfaces\Controller\ApiRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class WebRegistrationController extends ApiRestController
{
    #[Route('/', name: 'auth_web_register', methods: ['GET', 'POST'])]
    public function register(Request $request): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $id = Uuid::uuid4();
            $email = $form->get('email')->getData();
            $password = $form->get('plainPassword')->getData();

            $command = CreateUserCommand::make($id->value(), $email, $password);
            $this->commandBus->dispatch($command);

            $command = SendEmailConfirmationCommand::make($id->value());
            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('auth_web_login');
        }

        return $this->render('@Auth/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'auth_web_verify_email', methods: ['GET'])]
    public function verifyUserEmail(Request $request): Response
    {
        // if manual-auth
        // https://symfonycasts.com/screencast/symfony-security/manual-auth#play

        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('auth_web_register');
        }

        try {
            $command = ValidateEmailConfirmationCommand::make($id, $request->getUri());
            $this->commandBus->dispatch($command);
        } catch (EntityNotFoundByIdException|VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('auth_web_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('auth_web_login');
    }
}
