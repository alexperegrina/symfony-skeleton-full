<?php
declare(strict_types=1);

namespace Auth\Application\Command\SetName;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use AlexPeregrina\ValueObject\Domain\String\StringVO;
use AlexPeregrina\ValueObject\Domain\User\Name;
use Core\Domain\Messenger\Handler\CommandHandler;

class SetNameHandler implements CommandHandler
{
    public function __construct(private SetNameService $service)
    {}

    public function __invoke(SetNameCommand $command): void
    {
        $name = new Name(
            new StringVO($command->firstName()),
            $command->middleName() ? new StringVO($command->middleName()) : null,
            $command->lastName() ? new StringVO($command->lastName()) : null
        );

        $this->service->execute(new Uuid($command->id()), $name);
    }
}