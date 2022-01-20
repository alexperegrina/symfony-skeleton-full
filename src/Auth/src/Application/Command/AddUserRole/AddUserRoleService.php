<?php
declare(strict_types=1);

namespace Auth\Application\Command\AddUserRole;

use Auth\Domain\Exception\UserNotFoundByEmail;
use Auth\Domain\Repository\UserRepository;
use Core\Domain\Exception\EntityDuplicateException;

class AddUserRoleService
{
    public function __construct(private UserRepository $userRepository)
    {}

    /**
     * @throws UserNotFoundByEmail
     * @throws EntityDuplicateException
     */
    public function execute(string $email, array $roles): void
    {
        $user = $this->userRepository->findByEmail($email);

        $user->setRoles($roles);

        $this->userRepository->save($user);
    }
}