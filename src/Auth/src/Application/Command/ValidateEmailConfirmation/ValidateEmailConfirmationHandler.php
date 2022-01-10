<?php
declare(strict_types=1);

namespace Auth\Application\Command\ValidateEmailConfirmation;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Core\Domain\Messenger\Handler\CommandHandler;

class ValidateEmailConfirmationHandler implements CommandHandler
{
    public function __construct(private ValidateEmailConfirmationService $service)
    {}

    public function __invoke(ValidateEmailConfirmationCommand $command): void
    {
        $this->service->execute(
            new Uuid($command->userId()),
            $command->uri()
        );
    }
}