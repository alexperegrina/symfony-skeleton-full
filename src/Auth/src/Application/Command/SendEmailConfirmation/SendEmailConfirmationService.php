<?php
declare(strict_types=1);

namespace Auth\Application\Command\SendEmailConfirmation;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Auth\Domain\Entity\User;
use Auth\Domain\Repository\UserRepository;
use Core\Domain\Exception\EntityNotFoundByIdException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\VerifyEmail\Model\VerifyEmailSignatureComponents;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class SendEmailConfirmationService
{
    const VERIFY_EMAIL_ROUTE_NAME = 'auth_verify_email';

    public function __construct(
        private UserRepository $userRepository,
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer
    ) {}

    /**
     * @throws TransportExceptionInterface
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $userId): void
    {
        $user = $this->userRepository->findById($userId);

        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            self::VERIFY_EMAIL_ROUTE_NAME,
            $user->id()->value(),
            $user->email(),
            ['id' => $user->id()->value()]
        );

        $email = $this->generateEmail($signatureComponents, $user);

        $this->mailer->send($email);
    }

    private function generateEmail(VerifyEmailSignatureComponents $signatureComponents, User $user): TemplatedEmail
    {
        $email = new TemplatedEmail();
        $email->from(new Address('skeleton@skeleton.com', 'Skeleton CEO'));
        $email->to($user->email());
        $email->subject('Please Confirm your Email');
        $email->htmlTemplate('@Auth/registration/confirmation_email.html.twig');

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);

        return $email;
    }
}