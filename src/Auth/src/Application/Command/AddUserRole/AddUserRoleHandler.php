<?php
declare(strict_types=1);

namespace Auth\Application\Command\AddUserRole;

use Core\Domain\Messenger\Handler\CommandHandler;

class AddUserRoleHandler implements CommandHandler
{
    public function __construct(private AddUserRoleService $service)
    {}

    public function __invoke(AddUserRoleCommand $command): void
    {
        $this->service->execute($command->email(), $command->roles());
    }
}