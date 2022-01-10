<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli\GenerateCQS\Generator;

use Core\Interfaces\Cli\GenerateCQS\Model\Configuration;

interface Generator
{
    public static function generate(Configuration $configuration): string;
    public static function absolutePath(Configuration $configuration): string;
    public static function className(Configuration $configuration): string;
}