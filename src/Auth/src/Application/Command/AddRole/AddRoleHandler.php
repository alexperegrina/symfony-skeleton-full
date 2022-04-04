<?php
declare(strict_types=1);

namespace Auth\Application\Command\AddRole;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Auth\Domain\ValueObject\Role;
use Core\Domain\Messenger\Handler\CommandHandler;

class AddRoleHandler implements CommandHandler
{
    public function __construct(private AddRoleService $service)
    {}

    public function __invoke(AddRoleCommand $command): void
    {
        $this->service->execute(new Uuid($command->id()), Role::byValue($command->role()));
    }
}