<?php
declare(strict_types=1);

namespace Auth\Application\Command\SetRoles;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Core\Domain\Messenger\Handler\CommandHandler;

class SetRolesHandler implements CommandHandler
{
    public function __construct(private SetRolesService $service)
    {}

    public function __invoke(SetRolesCommand $command): void
    {
        $this->service->execute(new Uuid($command->id()), $command->roles());
    }
}