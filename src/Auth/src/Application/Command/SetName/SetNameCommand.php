<?php
declare(strict_types=1);

namespace Auth\Application\Command\SetName;

use Core\Domain\Messenger\Message\Command;

class SetNameCommand implements Command
{
    private function __construct(
        private string $id,
        private string $firstName,
        private ?string $middleName = null,
        private ?string $lastName = null,
    ) {}

    public static function make(
        string $id,
        string $firstName,
        ?string $middleName = null,
        ?string $lastName = null,
    ): self {
        return new self($id, $firstName, $middleName, $lastName);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function middleName(): ?string
    {
        return $this->middleName;
    }

    public function lastName(): ?string
    {
        return $this->lastName;
    }
}