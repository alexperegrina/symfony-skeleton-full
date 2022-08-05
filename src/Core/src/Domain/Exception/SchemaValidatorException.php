<?php
declare(strict_types=1);

namespace Core\Domain\Exception;

use Exception;

class SchemaValidatorException extends Exception
{
    public function __construct(private array $errors)
    {
        parent::__construct($this->errorMessage());
    }

    public function errors(): array
    {
        return $this->errors;
    }

    protected function errorMessage(): string
    {
        return json_encode($this->getMessageArray(), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    public function getMessageArray(): array
    {
        return [
            'message' => 'Schema validation failed',
            'errors' => $this->errors(),
        ];
    }
}