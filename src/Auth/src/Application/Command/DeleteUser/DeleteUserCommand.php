<?php
declare(strict_types=1);

namespace Auth\Application\Command\DeleteUser;

use Core\Domain\Messenger\Message\Command;

class DeleteUserCommand implements Command
{
    private function __construct(private string $id)
    {}

    public static function make(string $id): self
    {
        return new self($id);
    }

    public function id(): string
    {
        return $this->id;
    }
}