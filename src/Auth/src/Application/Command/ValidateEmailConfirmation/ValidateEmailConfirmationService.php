<?php
declare(strict_types=1);

namespace Auth\Application\Command\ValidateEmailConfirmation;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Auth\Application\Command\VerifyUser\VerifyUserService;
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
        private VerifyUserService $verifyUserService
    ) {}

    /**
     * @throws VerifyEmailExceptionInterface
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $userId, string $uri): void
    {
        $user = $this->userRepository->findById($userId);
        $this->verifyEmailHelper->validateEmailConfirmation($uri, $user->id()->value(), $user->email());
        $this->verifyUserService->execute($userId);
    }
}