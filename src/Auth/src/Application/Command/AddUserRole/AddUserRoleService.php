<?php
declare(strict_types=1);

namespace Auth\Application\Command\AddUserRole;

use Auth\Domain\Exception\UserNotFoundByEmail;
use Auth\Domain\Repository\UserRepository;

class AddUserRoleService
{
    public function __construct(private UserRepository $userRepository)
    {}

    public function execute(string $email, array $roles): void
    {
        $user = $this->userRepository->findByEmail($email);

        if (is_null($user)) {
            throw UserNotFoundByEmail::make($email);
        }

        $user->setRoles($roles);

        $this->userRepository->save($user);
    }
}