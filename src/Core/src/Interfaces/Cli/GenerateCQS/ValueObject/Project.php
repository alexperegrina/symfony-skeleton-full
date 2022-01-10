<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli\GenerateCQS\ValueObject;

use AlexPeregrina\ValueObject\Domain\String\StringVO;
use Exception;

class Project extends StringVO
{
    public const CORE = 'core';
    public const AUTH = 'auth';
    public const EXAMPLE = 'example';

    public const ALLOWED_VALUES = [
        self::CORE,
        self::AUTH,
        self::EXAMPLE,
    ];

    protected const FORMATS_VALUES = [
        self::CORE => 'Core',
        self::AUTH => 'Auth',
        self::EXAMPLE => 'Example',
    ];

    protected const USE_INTERNAL_MODULE = [
        self::CORE => false,
        self::AUTH => false,
        self::EXAMPLE => true,
    ];


    /**
     * @throws Exception
     */
    public function __construct(string $value)
    {
        $this->value = strtolower($value);
        parent::__construct($value);
        $this->guardAllowed($this->value);
    }

    /**
     * @throws Exception
     */
    private function guardAllowed(string $value): void
    {
        if (!in_array($value, self::ALLOWED_VALUES)) {
            throw new Exception('Invalid value in Project');
        }
    }

    public function value(bool $format = false): string
    {
        if ($format) {
            return self::FORMATS_VALUES[$this->value];
        }
        return $this->value;
    }

    public function useInternalModule(): bool
    {
        return self::USE_INTERNAL_MODULE[$this->value];
    }
}