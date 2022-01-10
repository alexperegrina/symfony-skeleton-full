<?php
declare(strict_types=1);

namespace Auth\Application\Command\DeleteUser;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Auth\Domain\Repository\UserRepository;

class DeleteUserService
{
    public function __construct(private UserRepository $userRepository)
    {}

    public function execute(Uuid $id): void
    {
        $user = $this->userRepository->findById($id);
        $this->userRepository->delete($user);
    }
}