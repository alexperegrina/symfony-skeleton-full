<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli\GenerateCQS\Generator;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Core\Interfaces\Cli\GenerateCQS\Model\Configuration;
use Core\Interfaces\Cli\GenerateCQS\Printer\PrinterPsrDeclare;

class ServiceGenerator implements Generator
{
    public static function generate(Configuration $configuration): string
    {
        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace($configuration->namespace());

        $class = $namespace->addClass(self::className($configuration));

        self::addMethodExecute($configuration, $class);

        $printer = new PrinterPsrDeclare();

        return $printer->printFile($file);
    }

    public static function absolutePath(Configuration $configuration): string
    {
        return $configuration->workDir() . '/' . self::className($configuration) . '.' . Configuration::EXTENSION_PHP;
    }

    public static function className(Configuration $configuration): string
    {
        return $configuration->name() . 'Service';
    }

    protected static function addMethodExecute(Configuration $configuration,  ClassType $class): void
    {
        $method = $class->addMethod('execute')
            ->setVisibility('public');
        $method->setReturnType('void');
    }
}