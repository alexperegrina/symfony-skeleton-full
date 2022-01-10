<?php
declare(strict_types=1);

namespace Auth\Application\Command\ValidateEmailConfirmation;

use Core\Domain\Messenger\Message\Command;

class ValidateEmailConfirmationCommand implements Command
{
    private function __construct(private string $userId, private string $uri)
    {}

    public static function make(string $userId, string $uri): self
    {
        return new self($userId, $uri);
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function uri(): string
    {
        return $this->uri;
    }
}