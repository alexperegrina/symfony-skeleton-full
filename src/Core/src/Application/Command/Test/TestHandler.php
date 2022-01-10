<?php
declare(strict_types=1);

namespace Core\Application\Command\Test;

use Core\Domain\Messenger\Handler\CommandHandler;

class TestHandler implements CommandHandler
{
    public function __construct(private TestService $service)
    {}

    public function __invoke(TestCommand $command): void
    {
        $this->service->execute();
    }
}