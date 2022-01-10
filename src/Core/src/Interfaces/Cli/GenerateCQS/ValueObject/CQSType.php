<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli\GenerateCQS\ValueObject;

use AlexPeregrina\ValueObject\Domain\String\StringVO;
use Exception;

class CQSType extends StringVO
{
    public const COMMAND = 'command';
    public const QUERY = 'query';

    public const ALLOWED_VALUES = [
        self::COMMAND,
        self::QUERY,
    ];

    protected const FORMATS_VALUES = [
        self::COMMAND => 'Command',
        self::QUERY => 'Query',
    ];

    protected const NAMESPACE_HANDLER_VALUES = [
        self::COMMAND => 'Core\Domain\Messenger\Handler\CommandHandler',
        self::QUERY => 'Core\Domain\Messenger\Handler\QueryHandler',
    ];

    protected const NAMESPACE_VALUES = [
        self::COMMAND => 'Core\Domain\Messenger\Message\Command',
        self::QUERY => 'Core\Domain\Messenger\Message\Query',
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
            throw new Exception('Invalid value in CQSType');
        }
    }

    public function value(bool $format = false): string
    {
        if ($format) {
            return self::FORMATS_VALUES[$this->value];
        }
        return $this->value;
    }

    public function namespace(bool $isHandler = true): string
    {
        if ($isHandler) {
            return self::NAMESPACE_HANDLER_VALUES[$this->value];
        }

        return self::NAMESPACE_VALUES[$this->value];
    }
}