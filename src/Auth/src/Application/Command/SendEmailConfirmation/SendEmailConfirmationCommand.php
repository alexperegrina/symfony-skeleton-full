<?php
declare(strict_types=1);

namespace Auth\Application\Command\SendEmailConfirmation;

use Core\Domain\Messenger\Message\Command;

class SendEmailConfirmationCommand implements Command
{
    private function __construct(private string $userId)
    {}

    public static function make(string $userId): self
    {
        return new self($userId);
    }

    public function userId(): string
    {
        return $this->userId;
    }
}