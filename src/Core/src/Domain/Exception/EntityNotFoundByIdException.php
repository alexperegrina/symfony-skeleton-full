<?php
declare(strict_types=1);

namespace Core\Domain\Exception;

use Exception;

class EntityNotFoundByIdException extends Exception
{
    protected function __construct($message = "")
    {
        parent::__construct($message);
    }

    public static function make(string $entity, string $id): self
    {
        $msg = "Entity: '$entity' not found by id: $id";
        return new self($msg);
    }
}