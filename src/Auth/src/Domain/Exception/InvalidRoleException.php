<?php
declare(strict_types=1);

namespace Auth\Domain\Exception;

use Exception;

class InvalidRoleException extends Exception
{
    /** @var int  */
    private const CODE = 444;

    protected function __construct($message = "")
    {
        parent::__construct($message, self::CODE);
    }

    public static function make(string $role): self
    {
        $msg = "Invalid role: $role";
        return new self($msg);
    }
}