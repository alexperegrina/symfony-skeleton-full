<?php
declare(strict_types=1);

namespace Core\Domain\Messenger\Bus;

use Core\Domain\Messenger\Message\Command;
use Throwable;

interface CommandBus extends MessageBus
{
    /**
     * @throws Throwable
     */
    public function dispatch(Command $command): void;
}