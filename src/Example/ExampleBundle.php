<?php
declare(strict_types=1);

namespace Example;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Example\DependencyInjection\ExampleExtension;

class ExampleBundle extends Bundle
{
    protected function getContainerExtensionClass(): string
    {
        return ExampleExtension::class;
    }
}