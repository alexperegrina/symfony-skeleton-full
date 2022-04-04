<?php
declare(strict_types=1);

namespace Auth\Application\Command\AddRole;

use Core\Domain\Messenger\Message\Command;

class AddRoleCommand implements Command
{
    private function __construct(private string $id, private string $role) {}

    public static function make(string $id, string $role): self
    {
        return new self($id, $role);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function role(): string
    {
        return $this->role;
    }
}