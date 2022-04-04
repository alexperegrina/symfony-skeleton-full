<?php
declare(strict_types=1);

namespace Auth\Application\Command\SetRoles;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Auth\Domain\Repository\UserRepository;
use Core\Domain\Exception\EntityDuplicateException;
use Core\Domain\Exception\EntityNotFoundByIdException;

class SetRolesService
{
    public function __construct(private UserRepository $userRepository)
    {}

    /**
     * @throws EntityDuplicateException
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $id, array $roles): void
    {
        $user = $this->userRepository->findById($id);

        $user->setRoles($roles);

        $this->userRepository->save($user);
    }
}