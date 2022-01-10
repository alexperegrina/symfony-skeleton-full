<?php
declare(strict_types=1);

namespace Auth\Application\Command\AddUserRole;

use Core\Domain\Messenger\Message\Command;

class AddUserRoleCommand implements Command
{
    private function __construct(private string $email, private array $roles)
    {}

    public static function make(string $email, array $roles): self
    {
        return new self($email, $roles);
    }

    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return string[]
     */
    public function roles(): array
    {
        return $this->roles;
    }
}