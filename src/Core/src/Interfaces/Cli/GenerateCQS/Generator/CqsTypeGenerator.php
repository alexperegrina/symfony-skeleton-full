<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli\GenerateCQS\Generator;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Core\Interfaces\Cli\GenerateCQS\Model\Configuration;
use Core\Interfaces\Cli\GenerateCQS\Printer\PrinterPsrDeclare;

class CqsTypeGenerator implements Generator
{
    public static function generate(Configuration $configuration): string
    {
        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace($configuration->namespace());
        $namespace->addUse($configuration->cqs()->namespace(false));

        $class = $namespace->addClass(self::className($configuration));

        $class->addImplement($configuration->cqs()->namespace(false));

        self::addMethodConstruct($configuration, $class);

        $printer = new PrinterPsrDeclare();

        return $printer->printFile($file);
    }

    public static function absolutePath(Configuration $configuration): string
    {
        return $configuration->workDir() . '/' . self::className($configuration) . '.' . Configuration::EXTENSION_PHP;
    }

    public static function className(Configuration $configuration): string
    {
        return $configuration->name() . $configuration->cqs()->value(true);
    }

    protected static function addMethodConstruct(Configuration $configuration,  ClassType $class): void
    {
        $method = $class->addMethod('__construct')
            ->setVisibility('private');

        $method = $class->addMethod('make')
            ->setVisibility('public')
            ->setStatic();
        $method->setReturnType('self');
        $method->setBody('return new self();');
    }
}