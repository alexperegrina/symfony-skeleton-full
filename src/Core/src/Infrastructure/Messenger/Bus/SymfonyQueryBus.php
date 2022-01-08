<?php
declare(strict_types=1);

namespace Core\Infrastructure\Messenger\Bus;

use Core\Domain\Messenger\Bus\QueryBus;
use Core\Domain\Messenger\Message\Query;

class SymfonyQueryBus extends SymfonyMessageBus implements QueryBus
{
    public function dispatch(Query $query): mixed
    {
        return $this->dispatchMessage($query);
    }
}