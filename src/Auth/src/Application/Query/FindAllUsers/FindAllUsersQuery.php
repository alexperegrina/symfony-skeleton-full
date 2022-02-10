<?php
declare(strict_types=1);

namespace Auth\Application\Query\FindAllUsers;

use Core\Domain\Messenger\Message\Query;

class FindAllUsersQuery implements Query
{
    private function __construct()
    {}

    public static function make(): self
    {
        return new self();
    }
}