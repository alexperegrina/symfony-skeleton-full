<?php
declare(strict_types=1);

namespace Core\Domain\Exception;

use Exception;

class RepositoryException extends Exception
{
    protected function __construct($message = "")
    {
        parent::__construct($message);
    }

    public static function make(string $message): self
    {
        return new self($message);
    }
}