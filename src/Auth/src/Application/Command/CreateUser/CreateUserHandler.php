<?php
declare(strict_types=1);

namespace Auth\Application\Command\CreateUser;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Core\Domain\Messenger\Handler\CommandHandler;

class CreateUserHandler implements CommandHandler
{
    public function __construct(private CreateUserService $createUserService)
    {}

    public function __invoke(CreateUserCommand $command): void
    {
        $this->createUserService->execute(
            new Uuid($command->id()),
            $command->email(),
            $command->password()
        );
    }
}