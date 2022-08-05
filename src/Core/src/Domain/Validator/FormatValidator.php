<?php
declare(strict_types=1);

namespace Core\Domain\Validator;

interface FormatValidator
{
    public static function type(): string;
    public static function name(): string;
    public static function validate(): string;
    public static function validateCallable(mixed $value): bool;
}