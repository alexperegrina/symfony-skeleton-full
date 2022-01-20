<?php
declare(strict_types=1);

namespace Auth\Application\Command\SetGender;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use AlexPeregrina\ValueObject\Domain\User\Gender;
use Core\Domain\Messenger\Handler\CommandHandler;

class SetGenderHandler implements CommandHandler
{
    public function __construct(private SetGenderService $service)
    {}

    public function __invoke(SetGenderCommand $command): void
    {
        $this->service->execute(new Uuid($command->id()), Gender::byValue($command->gender()));
    }
}