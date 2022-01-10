<?php
declare(strict_types=1);

namespace Auth\Application\Command\CreateUser;

use Core\Domain\Messenger\Message\Command;

class CreateUserCommand implements Command
{
    private function __construct(
        private string $id,
        private string $email,
        private string $password
    ) {}

    public static function make(string $id, string $email, string $password): self
    {
        return new self($id, $email, $password);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}