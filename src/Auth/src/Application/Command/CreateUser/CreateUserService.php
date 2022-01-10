<?php
declare(strict_types=1);

namespace Auth\Application\Command\CreateUser;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Auth\Domain\Entity\User;
use Auth\Domain\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function execute(Uuid $id, string $email, string $password): void
    {
        $user = new User($id, $email, $password);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $this->userRepository->save($user);
    }
}