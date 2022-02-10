<?php
declare(strict_types=1);

namespace Auth\Application\Query\FindAllUsers;

use Core\Domain\Messenger\Handler\QueryHandler;

class FindAllUsersHandler implements QueryHandler
{
    public function __construct(private FindAllUsersService $service)
    {}

    public function __invoke(FindAllUsersQuery $query)
    {
        return $this->service->execute();
    }
}