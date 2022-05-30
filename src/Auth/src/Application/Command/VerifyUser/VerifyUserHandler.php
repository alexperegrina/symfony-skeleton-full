<?php
declare(strict_types=1);

namespace Auth\Application\Command\VerifyUser;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Core\Domain\Messenger\Handler\CommandHandler;

class VerifyUserHandler implements CommandHandler
{
    public function __construct(private VerifyUserService $service)
    {}

    public function __invoke(VerifyUserCommand $command): void
    {
        $this->service->execute(new Uuid($command->id()));
    }
}