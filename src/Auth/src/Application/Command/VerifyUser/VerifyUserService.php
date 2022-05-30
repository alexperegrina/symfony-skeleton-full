<?php
declare(strict_types=1);

namespace Auth\Application\Command\VerifyUser;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Auth\Domain\Repository\UserRepository;
use Core\Domain\Exception\EntityNotFoundByIdException;

class VerifyUserService
{
    public function __construct(private UserRepository $userRepository)
    {}

    /**
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $id): void
    {
        $user = $this->userRepository->findById($id);
        $user->verify();
        $this->userRepository->save($user);
    }
}