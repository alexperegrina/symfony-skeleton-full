<?php
declare(strict_types=1);

namespace Auth\Application\Command\SetName;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use AlexPeregrina\ValueObject\Domain\User\Name;
use Auth\Domain\Repository\UserRepository;
use Core\Domain\Exception\EntityDuplicateException;
use Core\Domain\Exception\EntityNotFoundByIdException;

class SetNameService
{
    public function __construct(private UserRepository $userRepository)
    {}

    /**
     * @throws EntityDuplicateException
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $id, Name $name): void
    {
        $user = $this->userRepository->findById($id);

        $user->setName($name);

        $this->userRepository->save($user);
    }
}