<?php
declare(strict_types=1);

namespace Core\Domain\Messenger\Bus;

use Core\Domain\Messenger\Message\Query;
use Throwable;

interface QueryBus extends MessageBus
{
    /**
     * @throws Throwable
     */
    public function dispatch(Query $query): mixed;
}