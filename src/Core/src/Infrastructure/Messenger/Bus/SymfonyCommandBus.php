<?php
declare(strict_types=1);

namespace Core\Infrastructure\Messenger\Bus;

use Core\Domain\Messenger\Bus\CommandBus;
use Core\Domain\Messenger\Message\Command;

class SymfonyCommandBus extends SymfonyMessageBus implements CommandBus
{
    public function dispatch(Command $command): void
    {
        $this->dispatchMessage($command);
    }
}