<?php
declare(strict_types=1);

namespace Auth\Application\Command\SetGender;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use AlexPeregrina\ValueObject\Domain\User\Gender;
use Auth\Domain\Repository\UserRepository;
use Core\Domain\Exception\EntityDuplicateException;
use Core\Domain\Exception\EntityNotFoundByIdException;

class SetGenderService
{
    public function __construct(private UserRepository $userRepository)
    {}

    /**
     * @throws EntityDuplicateException
     * @throws EntityNotFoundByIdException
     */
    public function execute(Uuid $id, Gender $gender): void
    {
        $user = $this->userRepository->findById($id);

        $user->setGender($gender);

        $this->userRepository->save($user);
    }
}