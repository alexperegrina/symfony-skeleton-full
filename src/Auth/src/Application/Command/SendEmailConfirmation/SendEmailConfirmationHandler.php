<?php
declare(strict_types=1);

namespace Auth\Application\Command\SendEmailConfirmation;

use AlexPeregrina\ValueObject\Domain\Identity\Uuid;
use Core\Domain\Messenger\Handler\CommandHandler;

class SendEmailConfirmationHandler implements CommandHandler
{
    public function __construct(private SendEmailConfirmationService $service)
    {}

    public function __invoke(SendEmailConfirmationCommand $command): void
    {
        $this->service->execute(new Uuid($command->userId()));
    }
}