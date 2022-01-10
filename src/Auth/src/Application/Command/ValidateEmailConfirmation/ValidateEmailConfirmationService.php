<?php
declare(strict_types=1);

namespace Auth\Application\Command\ValidateEmailConfirmation;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Auth\Domain\Repository\UserRepository;
use Core\Domain\Exception\EntityDuplicateException;
use Core\Domain\Exception\EntityNotFoundByIdException;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class ValidateEmailConfirmationService
{
    public function __construct(
        private UserRepository $userRepository,
        private VerifyEmailHelperInterface $verifyEmailHelper,
    ) {}

    /**
     * @throws EntityDuplicateException
     * @throws VerifyEmailExceptionInterface
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $userId, string $uri): void
    {
        $user = $this->userRepository->findById($userId);

        $this->verifyEmailHelper->validateEmailConfirmation($uri, $user->id()->value(), $user->email());

        $user->setIsVerified(true);

        $this->userRepository->save($user);
    }
}