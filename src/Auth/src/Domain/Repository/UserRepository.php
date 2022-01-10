<?php
declare(strict_types=1);

namespace Auth\Domain\Repository;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Auth\Domain\Entity\User;
use Auth\Domain\Exception\UserNotFoundByEmail;
use Core\Domain\Exception\EntityDuplicateException;
use Core\Domain\Exception\EntityNotFoundByIdException;

interface UserRepository
{
    /**
     * @throws EntityDuplicateException
     */
    public function save(User $user): void;
    public function delete(User $user): void;

    /**
     * @throws UserNotFoundByEmail
     */
    public function findByEmail(string $email): User;
    public function findAll();

    /**
     * @throws EntityNotFoundByIdException
     */
    public function findById(Uuid $id): User;

    /**
     * @return User[]
     */
    public function findByRole(string $role): array;

    /**
     * @return User[]
     */
    public function findByRoleAndEnabled(string $role): array;
}