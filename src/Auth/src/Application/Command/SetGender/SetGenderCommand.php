<?php
declare(strict_types=1);

namespace Auth\Application\Command\SetGender;

use Core\Domain\Messenger\Message\Command;

class SetGenderCommand implements Command
{
    private function __construct(
        private string $id,
        private string $gender
    ) {}

    public static function make(
        string $id,
        string $gender
    ): self {
        return new self($id, $gender);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function gender(): string
    {
        return $this->gender;
    }
}