<?php
declare(strict_types=1);

namespace Auth\Application\Query\FindAllUsers;

use Auth\Domain\Repository\UserRepository;

class FindAllUsersService
{
    public function __construct(private UserRepository $userRepository)
    {}

    public function execute(): array
    {
        return $this->userRepository->findAll();
    }
}