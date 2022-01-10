<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli\GenerateCQS\Generator;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Core\Interfaces\Cli\GenerateCQS\Model\Configuration;
use Core\Interfaces\Cli\GenerateCQS\Printer\PrinterPsrDeclare;
use Core\Interfaces\Cli\GenerateCQS\ValueObject\CQSType;

class HandlerGenerator implements Generator
{
    public static function generate(Configuration $configuration): string
    {
        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace($configuration->namespace());

        $namespace->addUse($configuration->cqs()->namespace());

        $class = $namespace->addClass(self::className($configuration));

        $class->addImplement($configuration->cqs()->namespace());

        self::addMethodConstruct($configuration, $class);

        if ($configuration->cqs()->equals(new CQSType(CQSType::COMMAND))) {
            self::addMethodInvokeCommand($configuration, $class);
        } else {
            self::addMethodInvokeQuery($configuration, $class);
        }

        $printer = new PrinterPsrDeclare();

        return $printer->printFile($file);
    }

    public static function absolutePath(Configuration $configuration): string
    {
        return $configuration->workDir() . '/' . self::className($configuration) . '.' . Configuration::EXTENSION_PHP;
    }

    public static function className(Configuration $configuration): string
    {
        return $configuration->name() . 'Handler';
    }

    protected static function addMethodConstruct(Configuration $configuration,  ClassType $class): void
    {
        $method = $class->addMethod('__construct')
            ->setVisibility('public');
        $method->addPromotedParameter('service')->setPrivate()->setType($configuration->namespace().'\\'.ServiceGenerator::className($configuration));
    }

    protected static function addMethodInvokeCommand(Configuration $configuration,  ClassType $class): void
    {
        $method = $class->addMethod('__invoke')
            ->setVisibility('public');
        $method->addParameter('command')->setType($configuration->namespace().'\\'.CQSTypeGenerator::className($configuration));
        $method->setReturnType('void');
        $method->setBody('$this->service->execute();');
    }

    protected static function addMethodInvokeQuery(Configuration $configuration,  ClassType $class): void
    {
        $method = $class->addMethod('__invoke')
            ->setVisibility('public');
        $method->addParameter('query')->setType($configuration->namespace().'\\'.CQSTypeGenerator::className($configuration));
        $body = 'return $this->service->execute();'.PHP_EOL;
        $method->setBody($body);
    }
}