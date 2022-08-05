<?php
declare(strict_types=1);

namespace Core\Domain\Validator;

use Core\Domain\Exception\InvalidPathException;
use Core\Domain\Exception\SchemaValidatorException;

interface SchemaValidator
{
    /**
     * @throws SchemaValidatorException
     * @throws InvalidPathException
     */
    public function validate(object|array $data, string $pathSchema): object|array;
}