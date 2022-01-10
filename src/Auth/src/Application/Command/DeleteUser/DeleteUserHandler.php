<?php
declare(strict_types=1);

namespace Auth\Application\Command\DeleteUser;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Core\Domain\Messenger\Handler\CommandHandler;

class DeleteUserHandler implements CommandHandler
{
    public function __construct(private DeleteUserService $service)
    {}

    public function __invoke(DeleteUserCommand $command): void
    {
        $this->service->execute(new Uuid($command->id()));
    }
}