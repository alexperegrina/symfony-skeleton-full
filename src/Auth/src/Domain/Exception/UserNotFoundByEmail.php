<?php
declare(strict_types=1);

namespace Auth\Domain\Exception;

use Exception;

class UserNotFoundByEmail extends Exception
{
    protected function __construct($message = "")
    {
        parent::__construct($message);
    }

    public static function make(string $email): self
    {
        $msg = "User not found by email: $email";
        return new self($msg);
    }
}