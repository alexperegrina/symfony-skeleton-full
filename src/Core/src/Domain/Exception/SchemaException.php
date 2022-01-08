<?php
declare(strict_types=1);

namespace Core\Domain\Exception;

use Exception;

class SchemaException extends Exception
{
    public function __construct(private array $schema)
    {
        parent::__construct($this->errorMessage());
    }

    protected function errorMessage(): string
    {
        $values = ['message' => 'Invalid schema', 'schema' => json_encode($this->schema)];
        return json_encode($values);
    }
}