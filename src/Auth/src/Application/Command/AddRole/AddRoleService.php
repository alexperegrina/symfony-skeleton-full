<?php
declare(strict_types=1);

namespace Auth\Application\Command\AddRole;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Auth\Domain\Repository\UserRepository;
use Auth\Domain\ValueObject\Role;
use Core\Domain\Exception\EntityDuplicateException;
use Core\Domain\Exception\EntityNotFoundByIdException;

class AddRoleService
{
    public function __construct(private UserRepository $userRepository)
    {}

    /**
     * @throws EntityDuplicateException
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $id, Role $role): void
    {
        $user = $this->userRepository->findById($id);

        $user->addRole($role);

        $this->userRepository->save($user);
    }
}