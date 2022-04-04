<?php
declare(strict_types=1);

namespace Auth\Application\Command\SetRoles;

use Core\Domain\Messenger\Message\Command;

class SetRolesCommand implements Command
{
    private function __construct(private string $id, private array $roles) {}

    public static function make(string $id, array $roles): self
    {
        return new self($id, $roles);
    }

    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string[]
     */
    public function roles(): array
    {
        return $this->roles;
    }
}